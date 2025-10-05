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

use Morcheysha77\Faction\Commands\Properties\Command;

use Morcheysha77\Faction\Tasks\RequestAsyncVote;

class Vote extends Command
{

    /**
     * Vote constructor.
     */
    public function __construct()
    {
        parent::__construct("vote", "Allows you to receive voting rewards !");
    }
    
    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if(($s = $this->isPlayer($sender)) !== null)
            $s->getServer()->getAsyncPool()->submitTask(new RequestAsyncVote(strtolower($s->getName())));


        return true;

    }
}
