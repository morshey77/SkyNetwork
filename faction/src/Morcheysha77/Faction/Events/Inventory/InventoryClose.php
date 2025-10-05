<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Inventory;


use pocketmine\block\EnderChest;
use pocketmine\tile\EnderChest as EnderChestTile;

use pocketmine\inventory\EnderChestInventory;

use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryCloseEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\InventoryManager;

use Morcheysha77\Faction\Inventories\InvSee as InvSeeInventory;
use Morcheysha77\Faction\Inventories\EnderSee as EnderSeeInventory;

use Morcheysha77\Faction\Tiles\InvSee as InvSeeTile;
use Morcheysha77\Faction\Tiles\EnderSee as EnderSeeTile;
use Morcheysha77\Faction\Tiles\SeeInterface;

class InventoryClose implements Listener, SeeInterface
{

    /** @var Main $plugin */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param InventoryCloseEvent $event
     */
    public function InventoryCloseEvent(InventoryCloseEvent $event): void
    {

        $inventory = $event->getInventory();
        $holder = $inventory->getHolder();
        $tile = $holder->getLevel()->getTile($holder);
        $block = $holder->getLevel()->getBlock($holder);

        if($inventory instanceof EnderChestInventory) {
            if($tile instanceof EnderChestTile AND !$block instanceof EnderChest) {
                
                $players = $inventory->getViewers();
                $players[] = $event->getPlayer();
                $holder->getLevel()->sendBlocks($players, [$block]);
                $tile->close();
                
            }
        } elseif ($inventory instanceof InvSeeInventory OR $inventory instanceof EnderSeeInventory) {
            if($tile instanceof InvSeeTile OR $tile instanceof EnderSeeTile) {
                if(($manager = $this->plugin->getManagers("inventory")) !== null) {
                    if($manager instanceof InventoryManager)
                        $manager->synchronize(self::ACTION["close"], $tile->getTarget());
                }

                $players = $inventory->getViewers();
                $players[] = $event->getPlayer();
                $holder->getLevel()->sendBlocks($players, [$block]);
                $tile->close();

            }
        }
    }
}