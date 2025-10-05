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
use pocketmine\event\player\PlayerJoinEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\Managers\InventoryManager;

use Morcheysha77\Faction\Tiles\Interfaces\SeeInterface;

class PlayerJoin implements Listener, SeeInterface
{


    /** @var Main $plugin */
    private Main $plugin;

    /**
     * PlayerJoin constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }
    
    /**
     * @param PlayerJoinEvent $event
     */
    public function PlayerJoinEvent(PlayerJoinEvent $event): void
    {

        $event->setJoinMessage("");
        $player = $event->getPlayer();

        if($player instanceof FPlayer) {

            if(($manager = $this->plugin->getManagers("tpa")) !== null) {
                if($manager instanceof InventoryManager)
                    $manager->synchronize(self::ACTION["connect"], $player->getName());
            }

            $player->setCache();
        }
    }
}
