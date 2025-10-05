<?php


namespace Morcheysha77\Faction\Commands\Staff\Info;


use pocketmine\command\CommandSender;

use pocketmine\utils\Process;
use pocketmine\network\mcpe\protocol\ProtocolInfo;

use Morcheysha77\Faction\Commands\Properties\Command;

class Version extends Command
{

    /**
     * Kick constructor.
     */
    public function __construct()
    {

        parent::__construct("version", "Allows to show version's server");
        $this->setPermission("pocketmine.command.version");

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

            $server = $sender->getServer();
            $time = intval(microtime(true) - $server->getStartTime());

            $seconds = $time % 60;
            $minutes = null;
            $hours = null;
            $days = null;

            if($time >= 60) {

                $minutes = floor(($time % 3600) / 60);

                if($time >= 3600) {

                    $hours = floor(($time % (3600 * 24)) / 3600);

                    if($time >= 3600 * 24) $days = floor($time / (3600 * 24));
                }
            }

            $uptime = ($minutes !== null ? ($hours !== null ? ($days !== null ? $days . " days " : "")  . $hours . " hours " : "")
                    . $minutes . " minutes " : "") . $seconds . " seconds";
            $tps = ($server->getTicksPerSecond() < 15 ? ($server->getTicksPerSecond() < 8 ? "§c" : "§6") : "§a")
                . $server->getTicksPerSecond() . "(" . $server->getTickUsage() . "%)";
            $total = ($global = $server->getConfigGroup()->getPropertyInt("memory.global-limit", 0)) === 0
                ? number_format(round($global, 2), 2) : "Infinity";

            $sender->sendMessage(
                "                Version"
                . "\n    §f" . self::BAR . self::BAR . self::BAR
                . "\n §9Server : §f" . $server->getConfigGroup()->getConfigString("name")
                . "\n §9PocketMine-MP Version : §f" . $server->getPocketMineVersion()
                . "\n §9Minecraft Version : §f" . $server->getVersion()
                . "\n §9Version : §f" . ProtocolInfo::CURRENT_PROTOCOL
                . "\n"
                . "\n §9Uptime : §f" . $uptime
                . "\n §9TPS : §f" . $tps
                . "\n §9Threads : §f" . Process::getThreadCount()
                . "\n §9RAM : §f" . number_format(round((Process::getMemoryUsage() / 1024) / 1024, 2), 2) . " MB."
                . "\n §9Total RAM : §f" . $total . " MB."
                . "\n    §f" . self::BAR . self::BAR . self::BAR
            );

        }

        return true;
    }
}