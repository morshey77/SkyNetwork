<?php


namespace Morcheysha77\Faction\SubCommand\Faction\SubCommands\Player;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\SubCommand\SubCommand;

class Map extends SubCommand
{

    /**
     * @param FPlayer $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(FPlayer $sender, string $commandLabel, array $args): bool
    {
        return true;
    }
}