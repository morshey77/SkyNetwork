<?php

namespace skynetwork\hikabrain\game;

use pocketmine\player\Player;
use pocketmine\item\VanillaItems;

use pocketmine\Server;
use pocketmine\world\{Position, sound\ClickSound, sound\XpCollectSound, sound\XpLevelUpSound, WorldManager};

use pocketmine\color\Color;
use pocketmine\utils\Config;

use skynetwork\core\libs\kit\Kit;
use skynetwork\game\{managers\game\Game,
	managers\game\GameState,
	managers\game\IGameListener,
	managers\game\traits\Points,
	managers\team\Team};

use skynetwork\hikabrain\game\traits\{BlockEventTrait, EntityEventTrait, InventoryEventTrait, GameEventTrait, PlayerEventTrait};

use Exception;
use skynetwork\core\tasks\ClosureAsyncTask;

class HikabrainGame extends Game implements IGameListener
{

    use BlockEventTrait, EntityEventTrait, GameEventTrait, InventoryEventTrait, PlayerEventTrait, Points;

    public const MANAGE_INVENTORY = '§r§7§lManage Inventory';
	protected const COUNTDOWN_DEFAULT = 30;

    /** @var int $gamePort */
    private int $gamePort;

    protected array $colors = [];

    /** @var Kit $waitKit */
    protected Kit $waitKit;

    /** @var array<string, Kit> $spawnsKit */
    protected array $spawnsKit = [];

    /** @var array $goalsPosition */
    protected array $goalsPosition;

	protected int $countdown;

    /**
     * @param WorldManager $worldManager
     * @param string $dataFolder
     * @param string $arenaPath
     * @param array<Team> $teams
     * @throws Exception
     */
    public function __construct(WorldManager $worldManager, string $dataFolder, string $arenaPath, array $teams)
    {
        parent::__construct($worldManager, $dataFolder, $arenaPath, $teams);

        $arenaConfig = new Config($dataFolder . $arenaPath, Config::JSON);

        if(($goalsPosition = $arenaConfig->get('goalsPosition')) === null)
            throw new Exception('game::__construct() - Goals Position is not defined!');
        else if(!is_array($goalsPosition))
            throw new Exception('game::__construct() - Goals Position is not defined!');
        else if(count($goalsPosition) !== count($teams))
            throw new Exception('game::__construct() - Goals Position is not correctly defined!');

        $this->gamePort = (new Config($dataFolder . 'config.yml', Config::YAML))->get('game_port', 19132);
        $this->goalsPosition = $goalsPosition;
        $this->winPoints = $arenaConfig->get('team_win_points', 10);
        $this->colors = [new Color(132, 170, 250, 1), new Color(253, 98, 98, 1)];

    }

    public function start(): void
    {

        $this->waitKit = (new Kit())->add(VanillaItems::IRON_SWORD()->setCustomName(self::MANAGE_INVENTORY));

        // TODO: Add choose team (laine)

        parent::start();
    }

    public function stop(): void
    {
        foreach ($this->getTeams() as $team) {
            foreach ($team->all() as $player) {
                if($player instanceof Player)
                    $player->transfer($player->getServer()->getIp(), $this->gamePort);
            }
        }

        parent::stop();
    }

    public function update(): void
    {
        //TODO: MESSAGE

		if ($this->getState() === GameState::STARTING) {
			if ($this->canStarted()) {
                if($this->countdown > 0) {
                    foreach ($this->getTeams() as $team) {
                        foreach ($team->all() as $player) {
                            if($player instanceof Player) {
                                if($this->countdown === self::COUNTDOWN_DEFAULT)
                                    $player->getXpManager()->setXpLevel(30);

                                $player->getXpManager()->subtractXpLevels(1);

                            }
                        }

                        $team->broadcastSound(new XpCollectSound());
                    }

                    $this->countdown--;
                } else {
                    foreach ($this->getTeams() as $team)
                        $team->broadcastSound(new ClickSound());

                    $this->setState(GameState::RUNNING);
                }
			} else
				$this->setState(GameState::WAITING);
		}

        parent::update();
    }

    /**
     * @param Player $player
     * @return void
     */
    public function respawn(Player $player): void
    {
        foreach($this->getTeams() as $k => $team) {
            if($team->has($player->getUniqueId()->toString())) {

                $player->teleport($this->getArena()->getSpawnPosition($k));
                $this->spawnsKit[$player->getUniqueId()->toString()]->kit($player);

                break;
            }
        }
    }

    /**
     * @param string $key
     * @return Position
     */
    public function getGoalPosition(string $key): Position
    {

        $position = $this->goalsPosition[$key];

        return new Position($position['x'] ?? 0, $position['y'] ?? 0, $position['z'] ?? 0, $this->getArena()->getMap()->getWorld());
    }

	public function winGame(int $key): void
	{
        if($this->getState() === GameState::RUNNING) {
            $players = [];

            foreach ($this->getTeams() as $t)
                foreach ($t->all() as $p)
                    $players[] = $p;

            foreach ($this->getTeams() as $team)
                $team->broadcastMessage('WIN', [
                    match ($key) {
                        0 => 'Blue',
                        1 => 'Red'
                    }
                ], $players);

            Server::getInstance()->getAsyncPool()->submitTask(new ClosureAsyncTask(fn() => sleep(5), fn() => $this->setState(GameState::STOPPING)));
        }
	}
}
