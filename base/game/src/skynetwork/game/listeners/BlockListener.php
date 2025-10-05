<?php

namespace skynetwork\game\listeners;

use pocketmine\event\Listener;
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};

use skynetwork\game\Core;
use skynetwork\game\managers\game\IGameListener;

readonly class BlockListener implements Listener
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
     * @param BlockBreakEvent $event
     * @return void
     */
    public function BlockBreakEvent(BlockBreakEvent $event): void
    {

        $player = $event->getPlayer();

        $game = $this->core->getGameManager()->getGame($player);

        if($game instanceof IGameListener)
            $game->onBlockBreak($event);
    }

    /**
     * @noinspection PhpUnused
     * @param BlockPlaceEvent $event
     * @return void
     */
    public function BlockPlaceEvent(BlockPlaceEvent $event): void
    {

        $player = $event->getPlayer();

        $game = $this->core->getGameManager()->getGame($player);

        if($game instanceof IGameListener)
            $game->onBlockPlace($event);
    }
}