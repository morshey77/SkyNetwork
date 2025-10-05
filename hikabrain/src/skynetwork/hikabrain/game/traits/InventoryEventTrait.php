<?php

namespace skynetwork\hikabrain\game\traits;

use pocketmine\event\inventory\CraftItemEvent;

trait InventoryEventTrait
{

    /**
     * @param CraftItemEvent $event
     * @return void
     */
    public function onCraftItem(CraftItemEvent $event): void
    {
        $event->cancel();
    }
}