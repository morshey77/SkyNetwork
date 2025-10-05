<?php

namespace skynetwork\entity\listeners;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\event\{entity\EntityDamageByEntityEvent, entity\EntityDamageEvent, Listener};

use skynetwork\entity\entities\EntityClick;

/** @noinspection PhpUnused */
class EntityListener implements Listener
{

    public function __construct(PluginBase $plugin)
    {
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    /**
     * @param EntityDamageEvent $event
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function EntityDamageEvent(EntityDamageEvent $event): void
    {

        $player = $event->getEntity();

        if(
            $player instanceof EntityClick
            AND $event instanceof EntityDamageByEntityEvent
            AND $event->getDamager() instanceof Player
        )
            $player->onClick($event);
    }
}