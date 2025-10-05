<?php

namespace Morcheysha77\Faction\Events\Block;


use pocketmine\block\Lava;
use pocketmine\block\Water;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockUpdateEvent;


class BlockUpdate implements Listener
{


    /**
     * @param BlockUpdateEvent $event
     */
    public function BlockUpdateEvent(BlockUpdateEvent $event)
    {

        $block = $event->getBlock();
        $level_name = $block->getLevel()->getName();

        if((in_array($level_name, ["Shop", "FFA", "Boss"]) AND !($block instanceof Lava OR $block instanceof Water))
                OR ($level_name === "Faction" AND $block->getFloorX() <= 423 AND $block->getFloorX() >= 45 AND $block->getFloorZ() <= 468
                AND $block->getFloorZ() >= 102 AND ($block instanceof Lava OR $block instanceof Water))
                OR ($level_name === "Minage" AND $block->getFloorX() <= 309 AND $block->getFloorX() >= 234 AND $block->getFloorZ() <= 282 AND $block->getFloorZ() >= 200
                    AND ($block instanceof Lava OR $block instanceof Water))) $event->setCancelled();
    }
}