<?php


namespace Morcheysha77\Faction\Commands\Player\Stats;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class Stats extends Command
{

    /**
     * Stats constructor.
     */
    public function __construct()
    {
        parent::__construct("stats", "Allows to show stats's player", "", ["info"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {

        $player = empty($args[0]) ? $sender : $sender->getServer()->getPlayerByPrefix($args[0]);

        if($player instanceof FPlayer) {

            $sender->sendMessage(
                "            §9Info"
                . "\n    §f" . self::BAR . self::BAR
                . "\n §9Player : §f" . $player->getName()
                . "\n §9Rank : §f" . $player->getRank()
                . "\n §9Money : §f" . $player->getMoney()
                . "\n"
                . "\n §9Kill : §f" . $player->getKill()
                . "\n §9Death : §f" . $player->getDeath()
                . "\n §9K/D : §f" . $player->getKD()
                . "\n"
                . "\n §9KillStreak : §f" . $player->getKillStreak()
                . "\n §9Points : §f" . $player->getPoints()
                . "\n    §f" . self::BAR . self::BAR
            );

        } else $sender->sendMessage($this->notPlayer($args[0] ?? $sender->getName()));

        return true;
    }
}