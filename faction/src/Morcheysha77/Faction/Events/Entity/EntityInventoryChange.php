<?php


namespace Morcheysha77\Faction\Events\Entity;


use pocketmine\event\Listener;
use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\event\entity\EntityInventoryChangeEvent;


use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Managers\InventoryManager;

use Morcheysha77\Faction\Tiles\SeeInterface;

class EntityInventoryChange implements Listener, SeeInterface
{

    /** @var Main $plugin */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param EntityInventoryChangeEvent $event
     */
    public function EntityInventoryChangeEvent(EntityInventoryChangeEvent $event): void
    {

        $entity = $event->getEntity();
        if($entity instanceof FPlayer) {
            if(($manager = $this->plugin->getManagers("inventory")) !== null) {
                if($manager instanceof InventoryManager)
                    $manager->synchronize(
                        self::ACTION["interact"],
                        $entity->getName(),
                        $event instanceof EntityArmorChangeEvent ? $entity->getArmorInventory() : $entity->getInventory()
                    );
            }
        }
    }
}