<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Player\Teleport;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\TpaManager;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class TpaDeny extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * TpaDeny constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("tpadeny", "You can deny tp request to other player !", "", ["tpno"]);
        $this->plugin = $plugin;

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(($s = $this->isPlayer($sender)) !== null) {
            if(($manager = $this->plugin->getManagers("tpa")) !== null) {
                if($manager instanceof TpaManager) {
                    if(!$manager->isRequest($s->getName())) $s->sendMessage($s->translate("no_request"));
                    else {

                        $name = $manager->getRequestTpa($s->getName()) ?? $manager->getRequestHere($s->getName());
                        $player = $this->plugin->getServer()->getPlayerByPrefix($name);

                        if($player instanceof FPlayer) {

                            $player->sendMessage($player->translate("deny_request", [$s->getName()]));
                            $manager->removeRequest($player->getName());

                        } else $manager->removeRequest($name);

                        $s->sendMessage($s->translate("have_deny_request", [$name]));
                        $manager->removeRequest($s->getName());

                    }
                }
            }
        }

        return true;
    }
}