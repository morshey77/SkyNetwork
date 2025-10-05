<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ / 
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /  
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |   
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

class PlayerDeath implements Listener, Prefix
{

    /**
     * @param PlayerDeathEvent $event
     */
    public function PlayerDeathEvent(PlayerDeathEvent $event): void
    {

        $player = $event->getPlayer();

        if($player instanceof FPlayer) {

            $player->setCombatLogger(0);
            $cause = $player->getLastDamageCause();

            if($cause instanceof EntityDamageByEntityEvent) {

                $damager = $cause->getDamager();

                if($damager instanceof FPlayer) {

                    $player->addDeath(1);
                    $player->setKillStreak(0);
                    $damager->addKill(1);
                    $damager->addKillStreak(1);
                    $damager->setCombatLogger(0);

                    $damager->sendPopup(self::COMMAND . "Vous n'etes plus en combat");
                    $event->setDeathMessage("§1" . $damager->getName() . " §ea tuer §4" . $player->getName());

                }
            } 
        }
    }
}
