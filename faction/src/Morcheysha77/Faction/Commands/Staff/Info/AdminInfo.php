<?php


namespace Morcheysha77\Faction\Commands\Staff\Info;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Commands\Properties\Command;

class AdminInfo extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Kick constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("admininfo", "Allows to show info's player", "admininfo <player>", []);
        $this->setPermission("pocketmine.command.admininfo");
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
            if(empty($args) OR empty($args[0])) $sender->sendMessage($this->getUsage());
            else {
                if(($p = $this->isPlayerSilent($this->plugin->getServer()->getPlayerByPrefix($args[0]))) !== null) {

                    $sender->sendMessage(
                        "            §9AdminInfo"
                        . "\n    §f" . self::BAR . self::BAR
                        . "\n §9Player : §f" . $p->getName()
                        . "\n §9Lang : §f" . $p->getLang()
                        . "\n §9Coins : §f" . $p->getCoins()
                        . "\n §9Ping : §f" . $p->getNetworkSession()->getPing()
                        . "\n"
                        . "\n §9IP : §f" . $p->getNetworkSession()->getIp()
                        . "\n §9Port : §f" . $p->getNetworkSession()->getPort()
                        . "\n"
                        . "\n §9DeviceOS : §f" . $p->getDeviceOS()
                        . "\n §9InputMode : §f" . $p->getInputMode()
                        . "\n §9Model : §f" . $p->getModel()
                        . "\n §9Account : §f" . $p->getXuid()
                        . "\n    §f" . self::BAR . self::BAR
                    );

                } else $sender->sendMessage(self::COMMAND . "The player " . $args[0] . " doesn't exist !");
            }
        }

        return true;

    }
}