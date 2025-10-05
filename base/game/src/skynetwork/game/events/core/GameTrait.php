<?php

namespace skynetwork\game\events\core;

use skynetwork\game\managers\game\Game;

trait GameTrait
{

    /** @var Game $game */
    protected Game $game;

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }
}