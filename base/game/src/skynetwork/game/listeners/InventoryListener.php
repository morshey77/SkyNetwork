<?php

namespace skynetwork\game\listeners;

use pocketmine\event\Listener;
use pocketmine\event\inventory\CraftItemEvent;

use skynetwork\game\Core;
use skynetwork\game\managers\game\IGameListener;

readonly class InventoryListener implements Listener
{

    /**
     * @param Core $core
     */
    public function __construct(private Core $core)
    {
        if($this->core->getGameManager() !== null)
            $this->core->getServer()->getPluginManager()->registerEvents($this, $this->core);
    }

    /**
     * @param CraftItemEvent $event
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function CraftItemEvent(CraftItemEvent $event): void
    {

        $player = $event->getPlayer();
        if($this->core->getGameManager() !== null) {

            $game = $this->core->getGameManager()->getGame($event->getPlayer());

            if($game instanceof IGameListener)
                $game->onCraftItem($event);
        }
    }
}