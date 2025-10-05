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
use pocketmine\event\player\PlayerChatEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\FactionManager;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

class PlayerChat implements Listener, Prefix
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * PlayerChat constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerChatEvent $event
     */
    public function PlayerChatEvent(PlayerChatEvent $event): void
    {

        $player = $event->getPlayer();

        if($player instanceof FPlayer) {

            $event->cancel();
            $this->chatMessage($player, $event->getMessage());

        }
    }

    private function chatMessage(FPlayer $player, string $message): void
    {
        switch ($player->getChat()) {

            case "Faction":
                if($player->isInFaction() AND ($manager = $this->plugin->getManagers("faction")) !== null AND $manager instanceof FactionManager) {

                    foreach ($manager->getFaction($player->getFaction())?->getMembers() ?? [] as $name) {

                        $source = $player->getServer()->getPlayerByPrefix($name);

                        if($source instanceof FPlayer and $source->isOnline())
                            $source->sendMessage("§f" . $player->getChat() . " §9> [§f" . $player->getFactionRank() . "§9] §f"
                                . $player->getName() . " > §r" . $message);

                    }
                } else {

                    $player->setChat("Global");
                    $this->chatMessage($player, $message);

                }
                break;

            case "Ally":
                if($player->isInFaction() AND ($manager = $this->plugin->getManagers("faction")) !== null AND $manager instanceof FactionManager) {

                    $allies = [];
                    array_map(fn($ally) => array_map(fn($name) => array_push($allies, $name), $manager->getFaction($ally)?->getMembers() ?? []),
                        $manager->getFaction($player->getFaction())?->getAllies() ?? []);

                    foreach ($allies as $name) {

                        $source = $player->getServer()->getPlayerByPrefix($name);

                        if($source instanceof FPlayer and $source->isOnline())
                            $source->sendMessage("§f" . $player->getChat() . " §9> [§f" . $player->getFaction() . "§9][§f"
                                . $player->getFactionRank() . "§9] §f" . $player->getName() . " > §r" . $message);

                    }
                } else {

                    $player->setChat("Global");
                    $this->chatMessage($player, $message);

                }
                break;

            default:
                $player->getServer()->broadcastMessage("§9[§f" . $player->getRank() . "§9] [§f" . $player->getFaction()
                    . "§9] §f" . $player->getName() . " > §r" . $message);
        }
    }
}
