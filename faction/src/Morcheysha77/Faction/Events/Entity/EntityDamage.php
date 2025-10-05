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

use pocketmine\item\ItemIds;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

use Morcheysha77\Faction\Player\FPlayer;

class EntityDamage implements Listener
{

    /**
     * @param EntityDamageEvent $event
     */
    public function EntityDamageEvent(EntityDamageEvent $event)
    {

        $entity = $event->getEntity();
        $level_name = $entity->getWorld()->getFolderName();

        if($entity instanceof FPlayer) {
            if(in_array($level_name, ["Minage"])
                OR $event->getCause() === EntityDamageEvent::CAUSE_ENTITY_EXPLOSION
                OR ($event->getCause() === EntityDamageEvent::CAUSE_FALL
                    AND ($entity->getInventory()->getItemInHand()->getId() === ItemIds::DRAGON_BREATH
                        OR $entity->rtp > time())
                    OR ($level_name === "Faction" AND $entity->getPosition()->getFloorX() >= 209
                        AND $entity->getPosition()->getFloorX() <= 288
                        AND $entity->getPosition()->getFloorZ() >= 247 AND $entity->getPosition()->getFloorZ() <= 326)))
                $event->cancel();

            if(!$event->isCancelled()) {

                $entity->setScoreTag(
                    str_repeat("§a|", intval(round($entity->getHealth()))) .
                    str_repeat("§c|", intval(round($entity->getMaxHealth() - $entity->getHealth())))
                );

            }
        }
    }
}