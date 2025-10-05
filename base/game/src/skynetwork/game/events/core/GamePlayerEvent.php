<?php

namespace skynetwork\game\events\core;

use pocketmine\event\player\PlayerEvent;
use pocketmine\player\Player;
use skynetwork\game\managers\game\Game;

abstract class GamePlayerEvent extends PlayerEvent
{

    use GameTrait;

    /**
     * @param Game $game
     * @param Player $player
     */
    public function __construct(Game $game, Player $player)
    {

        $this->game = $game;
        $this->player = $player;

    }
}