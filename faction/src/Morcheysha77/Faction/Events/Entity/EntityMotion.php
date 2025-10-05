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

use pocketmine\entity\Human;
use pocketmine\entity\Living;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityMotionEvent;

class EntityMotion implements Listener
{

    /**
     * @param EntityMotionEvent $event
     */
    public function EntityMotionEvent(EntityMotionEvent $event): void
    {
        $entity = $event->getEntity();
        if($entity instanceof Living AND !$entity instanceof Human) $event->setCancelled();
    }
}