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
use pocketmine\event\player\PlayerQuitEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\TpaManager;
use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

class PlayerQuit implements Listener, Prefix
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * PlayerQuit constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerQuitEvent $event
     */
    public function PlayerQuitEvent(PlayerQuitEvent $event): void
    {

        $player = $event->getPlayer();

        if($player instanceof FPlayer) {
            if(!in_array($event->getQuitReason(), ["Internal server error", "transfer", "Unknown DeviceOS"]))
                if($player->isFight()) $player->kill();

            if(($manager = $this->plugin->getManagers("tpa")) !== null) {
                if($manager instanceof TpaManager) $manager->removeRequest($player->getName());
            }

            $player->delCache();
            $event->setQuitMessage("");

        }
    }
}
