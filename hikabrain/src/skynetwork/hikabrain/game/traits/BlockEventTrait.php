<?php

namespace skynetwork\hikabrain\game\traits;

use pocketmine\world\Position;
use pocketmine\block\VanillaBlocks;

use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};

trait BlockEventTrait
{

    /** @var array<string, Position> $blocks */
    private array $blocks = [];

    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function onBlockBreak(BlockBreakEvent $event): void
    {
        if(isset($this->blocks[$key = strval($event->getBlock()->getPosition()->add(0, -1, 0))]))
            unset($this->blocks[$key]);
        else
            $event->cancel();
    }

    /**
     * @param BlockPlaceEvent $event
     * @return void
     */
    public function onBlockPlace(BlockPlaceEvent $event): void
    {
        if(empty($this->blocks[$key = strval($event->getBlockAgainst()->getPosition())]))
            $this->blocks[$key] = $event->getBlockAgainst()->getPosition();
        else
            $event->cancel();
    }

    protected function clearBlocks(): void
    {
        foreach ($this->blocks as $block)
            $block->getWorld()->setBlock($block, VanillaBlocks::AIR());

        $this->blocks = [];
    }
}