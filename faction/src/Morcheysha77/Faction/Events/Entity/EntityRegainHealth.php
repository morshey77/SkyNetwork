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
use pocketmine\event\entity\EntityRegainHealthEvent;

use Morcheysha77\Faction\Player\FPlayer;

class EntityRegainHealth implements Listener
{

    /**
     * @param EntityRegainHealthEvent $event
     */
    public function EntityRegainHealthEvent(EntityRegainHealthEvent $event): void
    {

        $entity = $event->getEntity();

        if($entity instanceof FPlayer) {
            
            $entity->setScoreTag(
                str_repeat("§a|", intval(round($entity->getHealth()))) .
                str_repeat("§c|", intval(round($entity->getMaxHealth() - $entity->getHealth())))
            );

        }
    }
}