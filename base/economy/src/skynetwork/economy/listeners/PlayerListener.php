<?php

namespace skynetwork\economy\listeners;

use pocketmine\event\{Listener, player\PlayerJoinEvent, player\PlayerQuitEvent};

use skynetwork\economy\{Economy, managers\SessionManager};

class PlayerListener implements Listener
{

    /**
     * @param Economy $plugin
     */
    public function __construct(protected Economy $plugin) {}

    public function PlayerJoinEvent(PlayerJoinEvent $event): void
    {
        $manager = $this->plugin->getManager('Session');

        if($manager instanceof SessionManager)
            $manager->onPlayerJoin($event->getPlayer());

    }

    public function PlayerQuitEvent(PlayerQuitEvent $event): void
    {
        $manager = $this->plugin->getManager('Session');

        if($manager instanceof SessionManager)
            $manager->onPlayerQuit($event->getPlayer());

    }
}