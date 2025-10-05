<?php


namespace Morcheysha77\Faction\Commands\Staff;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Commands\Properties\Command;

use Morcheysha77\Faction\Tasks\RestartTask;

class Restart extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Restart constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("restart", "Allows to restart this server", "restart <type> <time>", ["redem"]);
        $this->setPermission("pocketmine.command.restart");
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
        if($this->testPermission($sender)) {
            if(empty($args) OR empty($args[0]) OR empty($args[1]))
                $sender->sendMessage($this->getUsage());
            else
                $this->plugin->getScheduler()->scheduleRepeatingTask(new RestartTask(intval($args[1]), $args[0]), 20);
        }

        return true;

    }
}