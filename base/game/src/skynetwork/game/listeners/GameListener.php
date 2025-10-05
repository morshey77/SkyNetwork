<?php

namespace skynetwork\game\listeners;

use pocketmine\event\Listener;

use skynetwork\game\Core;
use skynetwork\game\events\{GamePlayerFirstSpawnEvent,
    GamePlayerTeamChangeEvent,
    GamePlayerDeathByPlayerEvent,
    GamePlayerDeathEvent,
    GamePlayerJoinEvent,
    GamePlayerQuitEvent,
    GameStateChangeEvent};
use skynetwork\game\managers\game\IGameListener;

/** @noinspection PhpUnused */
readonly class GameListener implements Listener
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
     * @param GamePlayerDeathByPlayerEvent $event
     * @return void
     */
    public function GamePlayerDeathByPlayerEvent(GamePlayerDeathByPlayerEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onGamePlayerDeathByPlayer($event);
    }

    /**
     * @noinspection PhpUnused
     * @param GamePlayerDeathEvent $event
     * @return void
     */
    public function GamePlayerDeathEvent(GamePlayerDeathEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onGamePlayerDeath($event);
    }

    /**
     * @noinspection PhpUnused
     * @param GamePlayerJoinEvent $event
     * @return void
     */
    public function GamePlayerJoinEvent(GamePlayerJoinEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onGamePlayerJoin($event);
    }

    /**
     * @noinspection PhpUnused
     * @param GamePlayerQuitEvent $event
     * @return void
     */
    public function GamePlayerQuitEvent(GamePlayerQuitEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onGamePlayerQuit($event);
    }

    /**
     * @noinspection PhpUnused
     * @param GamePlayerTeamChangeEvent $event
     * @return void
     */
    public function GamePlayerTeamChangeEvent(GamePlayerTeamChangeEvent $event): void
    {

        $game = $this->core->getGameManager()->getGame($event->getPlayer());

        if($game instanceof IGameListener)
            $game->onGamePlayerTeamChange($event);
    }

    /**
     * @noinspection PhpUnused
     * @param GameStateChangeEvent $event
     * @return void
     */
    public function GameStateChangeEvent(GameStateChangeEvent $event): void
    {

        $game = $event->getGame();

        if($game instanceof IGameListener)
            $game->onGameStateChange($event);
    }
}