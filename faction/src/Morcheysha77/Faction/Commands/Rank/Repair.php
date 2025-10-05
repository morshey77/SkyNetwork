<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Rank;

use pocketmine\command\CommandSender;

use pocketmine\item\Armor;
use pocketmine\item\Tool;

use Morcheysha77\Faction\Commands\Properties\Command;

class Repair extends Command
{

    /**
     * Repair constructor.
     */
    public function __construct()
    {

        parent::__construct("repair", "You can repair your items !");
        $this->setPermission("pocketmine.command.repair");

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
                if(isset($args[0]) AND strtolower($args[0]) === "all") {

                    foreach ([$s->getInventory(), $s->getArmorInventory()] as $inventory) {
                        foreach($inventory->getContents() as $index => $item){
                            if(($item instanceof Tool || $item instanceof Armor) AND $item->getDamage() > 0) {

                                $inventory->setItem($index, $item->setDamage(0));
                                $s->sendMessage($s->translate("repair_all"));

                            }
                        }
                    }
                } else {
                    if((($item = ($inventory = $s->getInventory())->getItemInHand()) instanceof Tool || $item instanceof Armor)
                        AND $item->getDamage() > 0) {

                        $inventory->setItem($inventory->getHeldItemIndex(), $item->setDamage(0));
                        $s->sendMessage($s->translate("repair_hand"));

                    }
                }
            }
        }

        return true;
    }
}