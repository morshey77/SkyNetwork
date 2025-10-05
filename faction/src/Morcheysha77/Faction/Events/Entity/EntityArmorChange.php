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

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityArmorChangeEvent;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Entity;

class EntityArmorChange implements Listener, Entity
{

    /**
     * @param EntityArmorChangeEvent $event
     */
    public function EntityArmorChangeEvent(EntityArmorChangeEvent $event): void
    {

        $entity = $event->getEntity();

        if($entity instanceof FPlayer) {

            $new = $event->getNewItem();
            $old = $event->getOldItem();

            if (isset(self::ARMOR[$new->getId()])) {
                foreach (self::ARMOR[$new->getId()] as $id => $array) {

                    $entity->addEffect(new EffectInstance(
                        Effect::getEffect($id),
                        $array["time"],
                        intval($array["amplifier"]),
                        boolval($array["visible"])
                    ));

                }
            } else if (isset(self::ARMOR[$old->getId()])) {
                foreach (self::ARMOR[$old->getId()] as $id => $array) {

                    $entity->removeEffect($id);

                }
            }
        }
    }
}