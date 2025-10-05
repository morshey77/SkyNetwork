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

use Morcheysha77\Faction\Tasks\TeleportTask;

class Tpaccept extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Tpaccept constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("tpaccept", "You can accept tp request to other player !", "", ["tpyes"]);
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
                        if(is_string($name = $manager->getRequestTpa($s->getName()))) {

                            $player = $this->plugin->getServer()->getPlayerByPrefix($name);

                            if($player instanceof FPlayer) {

                                $this->plugin->getScheduler()->scheduleRepeatingTask(
                                    new TeleportTask($s, $player->getPosition(), "to §f" . $player->getName()),
                                    20);

                                $player->sendMessage($player->translate("tpa_accept_request", [$s->getName()]));
                                $manager->removeRequest($player->getName());

                            }
                        } else {

                            $player = $this->plugin->getServer()->getPlayerByPrefix($manager->getRequestHere($s->getName()));

                            if($player instanceof FPlayer) {

                                $this->plugin->getScheduler()->scheduleRepeatingTask(
                                    new TeleportTask($player, $s->getPosition(), "to §f" . $s->getName()),
                                    20);

                                $s->sendMessage($s->translate("tpahere_accept_request", [$player->getName()]));
                                $manager->removeRequest($player->getName());

                            }
                        }

                        $manager->removeRequest($s->getName());
                    }
                }
            }
        }

        return true;
    }
}