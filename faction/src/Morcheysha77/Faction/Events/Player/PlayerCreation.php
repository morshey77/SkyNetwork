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
use pocketmine\event\player\PlayerCreationEvent;

use Morcheysha77\Faction\Player\FPlayer;

class PlayerCreation implements Listener
{

    /**
     * @param PlayerCreationEvent $event
     */
    public function PlayerCreationEvent(PlayerCreationEvent $event): void
    {
        $event->setPlayerClass(FPlayer::class);
    }
}
