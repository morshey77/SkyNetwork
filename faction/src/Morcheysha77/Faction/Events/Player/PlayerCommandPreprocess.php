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
use pocketmine\event\player\PlayerCommandPreprocessEvent;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\StaffManager;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

class PlayerCommandPreprocess implements Listener, Prefix
{

    /** @var Main $plugin */
    private Main $plugin;
    /** @var array<string, int> $cooldown */
    private array $cooldown;
    private const TIME = 2;

    /**
     * PlayerCommandPreprocess constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerCommandPreprocessEvent $event
     */
    public function PlayerCommandPreprocessEvent(PlayerCommandPreprocessEvent $event): void
    {

        $player = $event->getPlayer();
        $message = $event->getMessage();

        if($player instanceof FPlayer) {
            if(empty($this->cooldown) OR empty($this->cooldown[$player->getName()]) OR $this->cooldown[$player->getName()] <= time()) {

                $this->cooldown[$player->getName()] = self::TIME + time();

                if(str_starts_with($message, "/")) {
                    if($player->isFight()) {

                        $player->sendPopup(self::COMMAND . "Vous ne pouvez pas faire §f" . explode(" ", $message)[0] ." §9en combat");
                        $event->cancel();

                    } else {

                        $args =  explode(" ", $message);

                        if(in_array("/msg", $args) OR in_array("/tell", $args) OR in_array("/w", $args)) {

                            array_shift($args);
                            $msg = "§9[§fMsg§9] §f" . $player->getName() . " §9to §f" . array_shift($args) . " §9> §f" . implode(" ", $args);

                        } else $msg = "§9[§fLogs§9] §f" . $player->getName() . " §9> §f" . $message;

                        $this->plugin->getLogger()->info($msg);

                        if(($manager = $this->plugin->getManagers("staff"))) {
                            if($manager instanceof StaffManager) {
                                foreach ($manager->getAllStaff() as $name => $staff) {

                                    if($staff->isOnline()) $staff->sendMessage($msg);
                                    else $manager->removeStaff($name);

                                }
                            }
                        }
                    }
                }
            } else $event->cancel();
        }
    }
}