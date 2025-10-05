<?php

namespace skynetwork\game\events;

use pocketmine\player\Player;
use skynetwork\game\events\core\GamePlayerEvent;
use skynetwork\game\managers\{game\Game, team\Team};

class GamePlayerDeathEvent extends GamePlayerEvent
{

    /** @var Team|null $team */
    protected ?Team $team;

    /**
     * @param Game $game
     * @param Player $player
     * @param int $cause
     */
    public function __construct(Game $game, Player $player, protected int $cause)
    {
        parent::__construct($game, $player);

        $this->team = $this->game->getTeam($player);
    }

    /**
     * @return int
     */
    public function getCause(): int
    {
        return $this->cause;
    }

    /**
     * @return Team|null
     */
    public function getTeam(): ?Team
    {
        return $this->team;
    }
}