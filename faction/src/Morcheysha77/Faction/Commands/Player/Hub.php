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

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Commands\Properties\Command;

use Morcheysha77\Faction\Tasks\TeleportTask;

class Hub extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Hub constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("hub", "You can now teleport to the hub !", null, ["spawn"]);
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
        if(($s = $this->isPlayer($sender)) !== null)
            $this->plugin->getScheduler()->scheduleRepeatingTask(
                new TeleportTask($s, $sender->getServer()->getWorldManager()->getDefaultWorld()->getSafeSpawn(), "Hub"),
                20);

        return true;
    }
}
