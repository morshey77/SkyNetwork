<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Staff;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\StaffManager;

use Morcheysha77\Faction\Commands\Properties\Command;

class Staff extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Staff constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("staff", "You can put staff mod !");
        $this->setPermission("pocketmine.command.staff");
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
            if($this->testPermission($s)) {
                if(($manager = $this->plugin->getManagers("staff")) !== null) {
                    if($manager instanceof StaffManager) {
                        if($manager->getStaff($s->getName()) !== false) {

                            $manager->removeStaff($s->getName());
                            $s->sendMessage($s->translate("staff_off"));

                        } else {

                            $manager->setStaff($s);
                            $s->sendMessage($s->translate("staff_on"));

                        }
                    }
                }
            }
        }

        return true;
    }
}