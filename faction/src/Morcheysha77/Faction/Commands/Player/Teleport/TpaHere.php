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

use Morcheysha77\Faction\Commands\Properties\Command;

class TpaHere extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * TpaHere constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("tpahere", "You can send tpahere request to other player !", "/tpahere <name>");
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
            if(empty($args) OR empty($args[0])) $s->sendMessage($this->getUsage());
            else {

                $player = $s->getServer()->getPlayerByPrefix($args[0]);

                if($player === null) $s->sendMessage($s->translate("offline_player"));
                else {
                    if(($manager = $this->plugin->getManagers("tpa")) !== null) {
                        if($manager instanceof TpaManager) {
                            if($manager->isRequest($player->getName())) $s->sendMessage($s->translate("already_request"));
                            else {

                                $manager->setRequestHere($s->getName(), $player->getName());
                                $player->sendMessage($s->translate("ask_request", [$s->getName()]));
                                $s->sendMessage($s->translate("send_request", [$player->getName()]));

                            }
                        }
                    }
                }
            }
        }

        return true;
    }
}