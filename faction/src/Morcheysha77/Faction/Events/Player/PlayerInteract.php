<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Player;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\block\Block;

use pocketmine\item\Item;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\Managers\FactionManager;

class PlayerInteract implements Listener
{

    /** @var Main $plugin */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerInteractEvent $event
     */
    public function PlayerInteractEvent(PlayerInteractEvent $event): void
    {

        $player = $event->getPlayer();
        $item = $event->getItem();
        $block = $event->getBlock();

        if(!$player->isOp() AND $player instanceof FPlayer AND (((in_array($block->getId(),
                    [
                        Block::FENCE_GATE, Block::ACACIA_FENCE_GATE, Block::BIRCH_FENCE_GATE, Block::DARK_OAK_FENCE_GATE,
                        Block::SPRUCE_FENCE_GATE, Block::JUNGLE_FENCE_GATE, Block::IRON_TRAPDOOR, Block::WOODEN_TRAPDOOR,
                        Block::TRAPDOOR, Block::OAK_FENCE_GATE, Block::CHEST, Block::TRAPPED_CHEST
                    ])
                        OR in_array($item->getId(),
                    [
                        Item::BUCKET, Item::DIAMOND_HOE, Item::GOLD_HOE, Item::IRON_HOE, Item::STONE_HOE, Item::WOODEN_HOE,
                        Item::DIAMOND_SHOVEL, Item::GOLD_SHOVEL, Item::IRON_SHOVEL, Item::STONE_SHOVEL, Item::WOODEN_SHOVEL
                    ]))
                    AND $player->getLevel()->getName() === "Faction" AND !(($manager = $this->plugin->getManagers("faction")) !== null
                    AND $manager instanceof FactionManager AND $manager->interactClaim($player, $block))) OR $block->getId() === Block::ITEM_FRAME_BLOCK))
            $event->setCancelled();

    }
}