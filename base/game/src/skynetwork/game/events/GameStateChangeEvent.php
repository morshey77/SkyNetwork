<?php

namespace skynetwork\game\events;

use pocketmine\event\{Cancellable, CancellableTrait, Event};
use skynetwork\game\events\core\GameTrait;
use skynetwork\game\managers\game\{Game, GameState};

class GameStateChangeEvent extends Event implements Cancellable
{

    use CancellableTrait, GameTrait;

    /**
     * @param Game $game
     * @param GameState $newState
     * @param GameState $oldState
     */
    public function __construct(Game $game, protected GameState $newState, protected GameState $oldState)
    {
        $this->game = $game;
    }

    /**
     * @return GameState
     */
    public function getNewState(): GameState
    {
        return $this->newState;
    }

    /**
     * @return GameState
     *
     * @noinspection PhpUnused
     */
    public function getOldState(): GameState
    {
        return $this->oldState;
    }
}