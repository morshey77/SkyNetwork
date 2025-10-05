<?php
/**
 * @noinspection PhpUnused
 * @noinspection PhpPureAttributeCanBeAddedInspection
 */

namespace skynetwork\game\managers\game;

use pocketmine\player\Player;
use pocketmine\world\WorldManager;

use pocketmine\network\mcpe\{convert\LegacySkinAdapter,
    protocol\PlayerListPacket,
    protocol\types\PlayerListEntry};

use pocketmine\utils\Config;

use skynetwork\core\libs\{bossbar\BossBar, langs\Translate, scoreboard\Scoreboard};

use skynetwork\game\events\{GamePlayerJoinEvent,
    GamePlayerQuitEvent,
    GamePlayerTeamChangeEvent,
    GameStateChangeEvent};
use skynetwork\game\managers\{arena\Arena, team\Team};

use Exception;

class Game
{

    /** @var bool $running */
    protected bool $running = false;

    /** @var string $uuid */
    protected string $uuid = '';

    /** @var GameState $state */
    protected GameState $state = GameState::LOADING;

    /** @var Arena $arena */
    protected Arena $arena;

    /** @var BossBar|null $bossBar */
    protected ?BossBar $bossBar = null;

    /** @var Scoreboard|null $scoreboard */
    protected ?Scoreboard $scoreboard = null;

    protected ?Translate $translate = null;

    /**
     * @param WorldManager $worldManager
     * @param string $dataFolder
     * @param string $arenaPath
     * @param array $teams
     * @throws Exception
     */
    public function __construct(
        WorldManager $worldManager, string $dataFolder, protected string $arenaPath, protected array $teams
    )
    {

        $this->translate = new Translate($dataFolder);

        $arenaConfig = new Config($dataFolder . $arenaPath, Config::JSON);


        if(($mapPath = $arenaConfig->get('mapPath')) === null)
            throw new Exception('game::__construct() - Map path is not defined!');

        if(($spawnsPosition = $arenaConfig->get('spawnsPosition')) === null)
            throw new Exception('game::__construct() - Spawns Position is not defined!');
        else if(!is_array($spawnsPosition))
            throw new Exception('game::__construct() - Spawns Position is not defined!');
        else if(count($spawnsPosition) !== count($teams))
            throw new Exception('game::__construct() - Spawns Position is not correctly defined!');

        if(($goalsPosition = $arenaConfig->get('goalsPosition')) === null)
            throw new Exception('game::__construct() - Goals Position is not defined!');
        else if(!is_array($goalsPosition))
            throw new Exception('game::__construct() - Goals Position is not defined!');
        else if(count($goalsPosition) !== count($teams))
            throw new Exception('game::__construct() - Goals Position is not correctly defined!');

        if(($waitPosition = $arenaConfig->get('waitVector3')) === null)
            throw new Exception('game::__construct() - Wait Position is not defined!');
        else if(!is_array($waitPosition))
            throw new Exception('game::__construct() - Wait Position is not defined!');
        else if(count($waitPosition) !== 3)
            throw new Exception('game::__construct() - Wait Position is not correctly defined!');

        foreach ($teams as $team) {
            if($team instanceof Team)
                $team->setGame($this);
            else
                throw new Exception('game::__construct() - Teams are not correctly defined!');
        }

        $this->setArena(new Arena($this, $worldManager, $dataFolder . $mapPath, $spawnsPosition, $waitPosition));
    }

    public function start(): void
    {
        $this->getArena()->getMap()->create();

        $this->running = true;
    }

    public function stop(): void
    {
        $this->getArena()->getMap()->destroy();

        $this->running = false;
    }


    public function update(): void
    {
        switch ($this->state) {

            case GameState::WAITING:
                if($this->canStarted())
                    $this->setState(GameState::STARTING);
                break;

            case GameState::STOPPING:
                if($this->isRunning())
                    $this->stop();
                break;

            default:
                break;
        }
    }

    /**
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->running;
    }

    /**
     * @return string
     */
    public function getUUID(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return self
     */
    public function setUUID(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return GameState
     */
    public function getState(): GameState
    {
        return $this->state;
    }

    /**
     * @param GameState $state
     * @return self
     */
    public function setState(GameState $state): self
    {

        $ev = new GameStateChangeEvent($this, $state, $this->state);
        $ev->call();

        if(!$ev->isCancelled())
            $this->state = $state;

        return $this;
    }

    /**
     * @return Arena
     */
    public function getArena(): Arena
    {
        return $this->arena;
    }

    /**
     * @param Arena $arena
     * @return self
     */
    public function setArena(Arena $arena): self
    {
        $this->arena = $arena;

        return $this;
    }

    /**
     * @return Scoreboard|null
     */
    public function getScoreboard(): ?Scoreboard
    {
        return $this->scoreboard;
    }

    /**
     * @param Scoreboard $scoreboard
     * @return $this
     */
    public function setScoreboard(Scoreboard $scoreboard): self
    {
        $this->scoreboard = $scoreboard;

        return $this;
    }

    /**
     * @return BossBar|null
     */
    public function getBossBar(): ?BossBar
    {
        return $this->bossBar;
    }

    /**
     * @param BossBar $bossBar
     * @return $this
     *
     * @noinspection PhpUnused
     */
    public function setBossBar(BossBar $bossBar): self
    {
        $this->bossBar = $bossBar;

        return $this;
    }

    /**
     * @return Translate
     */
    public function getTranslate(): Translate
    {
        return $this->translate;
    }

    /**
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    /**
     * @param Player $player
     * @return Team|null
     */
    public function getTeam(Player $player): ?Team
    {
        foreach ($this->teams as $team) {
            if ($team->has($player->getUniqueId()->toString()))
                return $team;
        }

        return null;
    }

    /**
     * @param Player $player
     * @param Team $team
     * @return $this
     * @throws Exception
     */
    public function setPlayerInTeam(Player $player, Team $team): self
    {
        $ev = new GamePlayerTeamChangeEvent($this, $player, $team, $this->getTeam($player));
        
        $team->add($player);
        $ev->call();

        return $this;
    }

    /**
     * @return bool
     */
    public function isFull(): bool
    {
        foreach ($this->getTeams() as $team) {
            if (!$team->isFull())
                return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function canStarted(): bool
    {
        foreach ($this->getTeams() as $team) {
            if (!$team->canStarted())
                return false;
        }

        return true;
    }

    /**
     * @param Player $player
     * @return void
     * @throws Exception
     */
    public function addPlayer(Player $player): void
    {
        foreach ($this->getTeams() as $team) {
            if (!$team->isFull()) {

                $this->setPlayerInTeam($player, $team);

                $playerListEntry = PlayerListEntry::createAdditionEntry(
                    $player->getUniqueId(), $player->getId(), $player->getDisplayName(),
                    (new LegacySkinAdapter())->toSkinData($player->getSkin()), $player->getXuid()
                );

                array_map(function (Player $p) use ($playerListEntry, $player) {
                    if ($p->getName() !== $player->getName())
                        $p->getNetworkSession()->sendDataPacket(PlayerListPacket::add([$playerListEntry]));
                }, $player->getServer()->getOnlinePlayers());

                $player->getNetworkSession()->sendDataPacket(PlayerListPacket::remove(array_map(function (Player $p) {
                    return PlayerListEntry::createAdditionEntry(
                        $p->getUniqueId(), $p->getId(), $p->getDisplayName(),
                        (new LegacySkinAdapter())->toSkinData($p->getSkin()), $p->getXuid()
                    );
                }, $player->getServer()->getOnlinePlayers())));

                foreach ($this->getTeams() as $t) {

                    array_map(function (Player $p) use ($playerListEntry, $player) {
                        if ($p->getName() !== $player->getName())
                            $p->getNetworkSession()->sendDataPacket(PlayerListPacket::add([$playerListEntry]));
                    }, $t->all());

                    $player->getNetworkSession()->sendDataPacket(PlayerListPacket::remove(array_map(function (Player $p) {
                        return PlayerListEntry::createAdditionEntry(
                            $p->getUniqueId(), $p->getId(), $p->getDisplayName(),
                            (new LegacySkinAdapter())->toSkinData($p->getSkin()), $p->getXuid()
                        );
                    }, $t->all())));
                }

                $ev = new GamePlayerJoinEvent($this, $player);
                $ev->call();

                break;
            }
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public function removePlayer(Player $player): void
    {
        $ev = new GamePlayerQuitEvent($this, $player);

        $this->getTeam($player)?->remove($player->getUniqueId()->toString());
        $ev->call();
    }
}