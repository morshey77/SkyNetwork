<?php

namespace skynetwork\hikabrain\game\traits;

use pocketmine\event\entity\{
    EntityDamageByEntityEvent,
    EntityItemPickupEvent,
    EntityTeleportEvent,
    ProjectileHitBlockEvent,
    ProjectileHitEntityEvent
};

trait EntityEventTrait
{

    /**
     * @param EntityDamageByEntityEvent $event
     * @return void
     */
    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event): void {}

    /**
     * @param EntityItemPickupEvent $event
     * @return void
     */
    public function onEntityItemPickup(EntityItemPickupEvent $event): void
    {
        $event->cancel();
    }

    /**
     * @param EntityTeleportEvent $event
     * @return void
     */
    public function onEntityTeleport(EntityTeleportEvent $event): void {}

    /**
     * @param ProjectileHitEntityEvent $event
     * @return void
     */
    public function onProjectileHitEntity(ProjectileHitEntityEvent $event): void {}

    /**
     * @param ProjectileHitBlockEvent $event
     * @return void
     */
    public function onProjectileHitBlock(ProjectileHitBlockEvent $event): void {}
}