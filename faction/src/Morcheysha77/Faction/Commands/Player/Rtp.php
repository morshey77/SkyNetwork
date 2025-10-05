<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ / 
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /  
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |   
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Player;

use pocketmine\command\CommandSender;

use pocketmine\world\Position;
use pocketmine\world\WorldException;

use Morcheysha77\Faction\Commands\Properties\Command;

class Rtp extends Command
{

    /**
     * Hub constructor.
     */
    public function __construct()
    {
        parent::__construct("rtp", "You can now teleport to random position !");
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
            try {

                $y = ($world = $s->getServer()->getWorldManager()->getDefaultWorld())
                    ->getHighestBlockAt($x = mt_rand(-5000, 5000), $z = mt_rand(-5000, 5000));
                $s->teleport(new Position($x, $y, $z, $world));
                $s->translate("world_tp_coord", [$x, $y, $z]);

            } catch (WorldException $e) {
                $s->translate("world_exception", [$e->getCode(), $e->getMessage()]);
            }
        }

        return true;
    }
}
