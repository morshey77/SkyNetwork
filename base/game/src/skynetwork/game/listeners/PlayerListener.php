<?php

namespace skynetwork\game\listeners;

use pocketmine\event\{
    Listener,
    player\PlayerChatEvent,
    player\PlayerInteractEvent,
    player\PlayerDropItemEvent,
    player\PlayerItemConsumeEvent,
    player\PlayerJoinEvent,
    player\PlayerMoveEvent,
    player\PlayerQuitEvent
};

use skynetwork\game\Core;
use skynetwork\game\managers\game\IGameListener;

use Exception;

/** @noinspection PhpUnused */
readonly class PlayerListener implements Listener
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
     * @noinspection PhpUnused
     * @param PlayerChatEvent $event
     * @return void
     */
    public function PlayerChatEvent(PlayerChatEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onPlayerChat($event);

    }

    /**
     * @noinspection PhpUnused
     * @param PlayerDropItemEvent $event
     * @return void
     */
    public function PlayerDropItemEvent(PlayerDropItemEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onPlayerDropItem($event);
    }

    /**
     * @noinspection PhpUnused
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function PlayerInteractEvent(PlayerInteractEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onPlayerInteract($event);
    }

    /**
     * @noinspection PhpUnused
     * @param PlayerItemConsumeEvent $event
     * @return void
     */
    public function PlayerItemConsumeEvent(PlayerItemConsumeEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onPlayerItemConsume($event);
    }

    /**
     * @noinspection PhpUnused
     * @param PlayerMoveEvent $event
     * @return void
     */
    public function PlayerMoveEvent(PlayerMoveEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onPlayerMove($event);
    }

    /**
     * @noinspection PhpUnused
     * @param PlayerJoinEvent $event
     * @return void
     * @throws Exception
     */
    public function PlayerJoinEvent(PlayerJoinEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game === null)
            $this->core->getGameManager()->addPlayer($event->getPlayer());
    }

    /**
     * @noinspection PhpUnused
     * @param PlayerQuitEvent $event
     * @return void
     * @throws Exception
     */
    public function PlayerQuitEvent(PlayerQuitEvent $event): void
    {
        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game !== null)
            $this->core->getGameManager()->removePlayer($event->getPlayer());
    }
}