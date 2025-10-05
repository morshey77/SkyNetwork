<?php

namespace Morcheysha77\Faction\Commands\Properties;


use pocketmine\command\Command as CommandClass;
use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

abstract class Command extends CommandClass implements Prefix
{

    public function isPlayer(CommandSender $sender): ?FPlayer
    {
        $is_player = $this->isPlayerSilent($sender);

        if(empty($is_player)) $sender->sendMessage(self::COMMAND . "§cRun this Command only in Game !");

        return $is_player;
    }

    public function isPlayerSilent(CommandSender $sender): ?FPlayer
    {
        if($sender instanceof FPlayer) return $sender;

        return null;
    }

    public function notPlayer(string $s): string
    {
        return self::COMMAND . "The player §f" . $s . " §9doesn't exist !";
    }
}