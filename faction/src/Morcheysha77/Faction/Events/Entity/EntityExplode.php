<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Entity;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityExplodeEvent;

class EntityExplode implements Listener
{

    /**
     * @param EntityExplodeEvent $event
     */
    public function EntityExplodeEvent(EntityExplodeEvent $event)
    {

        $entity = $event->getEntity();
        
        if($entity->getLevel()->getName() !== "Faction" OR ($entity->getX() <= 423
                AND $entity->getX() >= 45
                AND $entity->getZ() <= 468
                AND $entity->getZ() >= 102)) $event->setCancelled();
    }
}