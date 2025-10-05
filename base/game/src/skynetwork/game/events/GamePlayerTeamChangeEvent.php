<?php

namespace skynetwork\game\events;

use pocketmine\player\Player;
use skynetwork\game\events\core\GamePlayerEvent;
use skynetwork\game\managers\{game\Game, team\Team};

class GamePlayerTeamChangeEvent extends GamePlayerEvent
{

    /**
     * @param Game $game
     * @param Player $player
     * @param Team|null $newTeam
     * @param Team|null $oldTeam
     */
    public function __construct(Game $game, Player $player, protected ?Team $newTeam, protected ?Team $oldTeam)
    {
        parent::__construct($game, $player);
    }

    /**
     * @return Team|null
     *
     * @noinspection PhpUnused
     */
    public function getNewTeam(): ?Team
    {
        return $this->newTeam;
    }

    /**
     * @return Team|null
     *
     * @noinspection PhpUnused
     */
    public function getOldTeam(): ?Team
    {
        return $this->oldTeam;
    }
}