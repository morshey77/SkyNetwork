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


use pocketmine\block\Block;
use pocketmine\item\VanillaItems;

use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Commands\Properties\Command;

class EnderChest extends Command
{

    /**
     * EnderChest constructor.
     */
    public function __construct()
    {

        parent::__construct("enderchest", "You can show your enderchest !", null, ["ec"]);
        $this->setPermission("pocketmine.command.enderchest");

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
                if($s->getWorld()->getBlock($s->getPosition()) instanceof Block) {

                    $pickaxe = VanillaItems::DIAMOND_PICKAXE();
                    $s->getWorld()->useBreakOn($s->getPosition(), $pickaxe, $s);
    
                }

                $s->setCurrentWindow($s->getEnderInventory());
            }
        }

        return true;
    }
}