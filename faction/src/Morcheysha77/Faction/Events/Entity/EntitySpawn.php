<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Entity;

use pocketmine\entity\Living;
use pocketmine\entity\Human;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntitySpawnEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\SpawnerManager;

class EntitySpawn implements Listener
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * EntitySpawn constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin) 
    {
        $this->plugin = $plugin;
    }

    /**
     * @param EntitySpawnEvent $event
     */
    public function EntitySpawnEvent(EntitySpawnEvent $event)
    {

        $entity = $event->getEntity();
        
        if(($manager = $this->plugin->getManagers("spawner")) !== null)
            if($manager instanceof SpawnerManager)
                if($entity instanceof Living and !$entity instanceof Human) $manager->addToClosestStack($entity);
    }
}