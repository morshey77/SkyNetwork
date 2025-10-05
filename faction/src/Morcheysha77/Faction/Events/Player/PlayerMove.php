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
use pocketmine\event\player\PlayerMoveEvent;

use Morcheysha77\Faction\Player\FPlayer;

class PlayerMove implements Listener
{

    /**
     * @param PlayerMoveEvent $event
     */
    public function PlayerMoveEvent(PlayerMoveEvent $event): void
    {

        $player = $event->getPlayer();
        $to = $event->getTo();

        if($player->getWorld()->getDisplayName() === "Faction" AND $player->getGamemode() !== FPlayer::CREATIVE AND !$player->isOp() AND ($to->getFloorX() >= 15000
            OR $to->getFloorX() <= -15000 OR $to->getFloorZ() >= 15000 OR $to->getFloorZ() <= -15000)) $event->cancel();

    }
}
