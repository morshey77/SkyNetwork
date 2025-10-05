<?php


namespace Morcheysha77\Faction\Events\Inventory;


use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryTransactionEvent;

use pocketmine\inventory\transaction\action\SlotChangeAction;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\InventoryManager;

use Morcheysha77\Faction\Inventories\InvSee as InvSeeInventory;
use Morcheysha77\Faction\Inventories\EnderSee as EnderSeeInventory;

use Morcheysha77\Faction\Tiles\InvSee as InvSeeTile;
use Morcheysha77\Faction\Tiles\EnderSee as EnderSeeTile;
use Morcheysha77\Faction\Tiles\SeeInterface;

class InventoryTransaction implements Listener, SeeInterface
{

    /** @var Main $plugin */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param InventoryTransactionEvent $event
     */
    public function InventoryTransactionEvent(InventoryTransactionEvent $event): void
    {

        $transaction = $event->getTransaction();

        foreach ($transaction->getActions() as $action) {
            if($action instanceof SlotChangeAction) {

                $inventory = $action->getInventory();

                if ($inventory instanceof InvSeeInventory OR $inventory instanceof EnderSeeInventory) {

                    $tile = $inventory->getTile();

                    if($tile instanceof InvSeeTile OR $tile instanceof EnderSeeTile) {
                        if(($manager = $this->plugin->getManagers("inventory")) !== null) {
                            if($manager instanceof InventoryManager)
                                $manager->synchronize(self::ACTION["interact"], $tile->getTarget(), $tile);

                        }
                    }
                }
            }
        }
    }
}