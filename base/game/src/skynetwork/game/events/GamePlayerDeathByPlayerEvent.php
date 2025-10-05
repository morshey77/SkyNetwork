<?php

namespace skynetwork\game\events;

use pocketmine\player\Player;
use skynetwork\game\managers\{game\Game, team\Team};

class GamePlayerDeathByPlayerEvent extends GamePlayerDeathEvent
{

    /** @var Team|null $damagerTeam */
    protected ?Team $damagerTeam;

    /**
     * @param Game $game
     * @param Player $player
     * @param int $cause
     * @param Player $damager
     */
    public function __construct(Game $game, Player $player, int $cause, protected Player $damager)
    {
        parent::__construct($game, $player, $cause);

        $this->damagerTeam = $this->game->getTeam($damager);
    }

    /**
     * @return Player
     *
     * @noinspection PhpUnused
     */
    public function getDamager(): Player
    {
        return $this->damager;
    }

    /**
     * @return Team|null
     *
     * @noinspection PhpUnused
     */
    public function getDamagerTeam(): ?Team
    {
        return $this->damagerTeam;
    }
}