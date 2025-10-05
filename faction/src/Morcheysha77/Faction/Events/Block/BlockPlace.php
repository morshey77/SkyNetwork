<?php

namespace Morcheysha77\Faction\Events\Block;


use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\Managers\FactionManager;

class BlockPlace implements Listener
{

    /** @var Main $plugin */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param BlockPlaceEvent $event
     */
    public function BlockPlaceEvent(BlockPlaceEvent $event)
    {

        $player = $event->getPlayer();
        $block = $event->getBlock();
        $level_name = $player->getLevel()->getName();

        if($player instanceof FPlayer AND $player->getGamemode() !== FPlayer::CREATIVE AND !$player->isOp() AND (in_array($level_name, ["FFA"])
                OR ($level_name === "Faction" AND (($block->getFloorX() <= 423 AND $block->getFloorX() >= 45
                            AND $block->getFloorZ() <= 468 AND $block->getFloorZ() >= 102) OR
                        ($block->getFloorX() <= 15000 AND $block->getFloorX() >= -15000
                            AND $block->getFloorZ() <= 15000 AND $block->getFloorZ() >= -15000)
                        OR (($manager = $this->plugin->getManagers("faction")) !== null AND $manager instanceof FactionManager
                            AND $manager->interactClaim($player, $block))))
                OR ($level_name === "Minage" AND $block->getFloorX() <= 309 AND $block->getFloorX() >= 234
                    AND $block->getFloorZ() <= 282 AND $block->getFloorZ() >= 200))) $event->setCancelled();
    }
}