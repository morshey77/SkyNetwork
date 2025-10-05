<?php

namespace skynetwork\entity\entities;

use pocketmine\event\entity\EntityDamageByEntityEvent;

interface EntityClick
{

    /**
     * @param EntityDamageByEntityEvent $event
     * @return bool
     */
    public function onClick(EntityDamageByEntityEvent $event): bool;

}