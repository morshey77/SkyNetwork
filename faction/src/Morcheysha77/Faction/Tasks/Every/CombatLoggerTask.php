<?php


namespace Morcheysha77\Faction\Tasks\Every;


use pocketmine\Server;

use pocketmine\scheduler\Task;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Command as CommandConstant;

class CombatLoggerTask extends Task implements CommandConstant
{

    /**
     * @return int
     */
    public function getEverySecond(): int
    {
        return 1;
    }

    public function onRun(): void
    {
        foreach(Server::getInstance()->getOnlinePlayers() as $player) {
            if($player instanceof FPlayer) {
                if($player->getCombatLogger() > 0 AND !$player->isFight()) {

                    $player->setCombatLogger(0);
                    $player->sendPopup(self::PREFIX . "Vous n'etes plus en combat");

                }
            }
        }
    }
}