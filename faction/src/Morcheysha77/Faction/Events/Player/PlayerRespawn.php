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
use pocketmine\event\player\PlayerRespawnEvent;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

class PlayerRespawn implements Listener, Prefix
{

    /**
     * @param PlayerRespawnEvent $event
     */
    public function PlayerRespawnEvent(PlayerRespawnEvent $event): void
    {
        
        if(($player = $event->getPlayer()) instanceof FPlayer) {
            
            $event->setRespawnPosition($event->getPlayer()->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            $player->setScoreTag(
                str_repeat("§a|", intval(round($player->getHealth()))) .
                str_repeat("§c|", intval(round($player->getMaxHealth() - $player->getHealth())))
            );
            
        } 
    }
}
