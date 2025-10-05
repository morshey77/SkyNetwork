<?php

namespace skynetwork\game\managers;

use pocketmine\player\Player;

use pocketmine\scheduler\ClosureTask;
use pocketmine\scheduler\TaskHandler;

use skynetwork\core\managers\ArrayManager;

use skynetwork\game\Core;
use skynetwork\game\managers\game\{Game, GameState};

use Exception;

class GameManager extends ArrayManager
{

    /** CODE_LENGTH is length of game's UUID */
    private const CODE_LENGTH = 6;

    /** @var TaskHandler $handler */
    private TaskHandler $handler;

    public function __construct(private readonly Core $core)
    {
        $this->handler = $this->core->getScheduler()->scheduleRepeatingTask($this->getClosureTask(), 20);
    }

    public function destroy()
    {
        foreach ($this->all() as $game)
            $game->stop();

        $this->handler->cancel();
    }

    public function getGame(Player $player): ?Game
    {
        foreach ($this->all() as $game)
            if($game instanceof Game)
                foreach ($game->getTeams() as $team)
                    if($team->has($player->getUniqueId()->toString()))
                        return $game;

        return null;
    }

    /**
     * @param Player $player
     * @return void
     * @throws Exception
     */
    public function addPlayer(Player $player): void
    {
        foreach ($this->all() as $game) {
            if($game instanceof Game) {
                if($game->getState() === GameState::WAITING OR $game->getState() === GameState::STARTING) {
                    if(!$game->isFull()) {
                        $game->addPlayer($player);

                        return;
                    }
                }
            }
        }

        $result = ($this->core->getCreateGame())();

        if($result instanceof Game) {
            try {
                $this->add($result);
                $result->start();
                $result->addPlayer($player);
            } catch (Exception $e) {
                $this->core->getLogger()->error($e->getMessage());
            }
        } else {

            $player->kick($reason = 'GameManager: game creation failed!');

            throw new Exception($reason);
        }
    }

    /**
     * @param Player $player
     * @return void
     * @throws Exception
     */
    public function removePlayer(Player $player): void
    {
        $this->getGame($player)?->removePlayer($player);
    }

    /**
     * @param object $obj
     * @param string $key
     * @return void
     * @throws Exception
     */
    public function add(object $obj, string $key = ''): void
    {
        if (!$obj instanceof Game)
            throw new Exception('GameManager::add() - GameManager can only add game objects!');

        while (true) {
            if (empty($this->elements[$code = self::generate()])) {

                $obj = $obj->setUUID($code);

                break;
            }
        }

        parent::add($obj, $obj->getUUID());
    }

    public function getClosureTask(): ClosureTask
    {
        return new ClosureTask(function () {
            foreach ($this->all() as $game)
                if ($game instanceof Game AND $game->isRunning())
                    $game->update();

        });
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function generate(): string
    {
        return bin2hex(random_bytes(self::CODE_LENGTH / 2));
    }
}