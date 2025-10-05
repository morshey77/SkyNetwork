<?php


namespace Morcheysha77\Faction\SubCommand\Faction\SubCommands\Home;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\SubCommand\SubCommand;

class Delhome extends SubCommand
{

    /**
     * @param FPlayer $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(FPlayer $sender, string $commandLabel, array $args): bool
    {
        if($sender->isInFaction()) {
            if($sender->isOfficer()) {


                $sender->sendMessage($sender->translate(""));

            } else $sender->sendMessage($sender->translate(""));
        } else $sender->sendMessage($sender->translate(""));

        return true;
    }
}