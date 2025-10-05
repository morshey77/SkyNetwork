<?php


namespace Morcheysha77\Faction\Tasks;


use pocketmine\Server;
use pocketmine\scheduler\Task;

use Morcheysha77\Faction\Constants\Command as CommandConstant;

class RestartTask extends Task implements CommandConstant
{

    /** @var int $second */
    private int $second;
    /** @var string $type */
    private string $type;

    /**
     * RestartTask constructor.
     * @param int $second
     * @param string $type
     */
    public function __construct(int $second, string $type)
    {

        $this->second = $second;
        $this->type = $type;

    }

    public function onRun(): void
    {

        switch ($this->type) {

            case 'maintenance':
                Server::getInstance()->broadcastMessage(self::PREFIX . "§9Maintenance dans §f" . $this->second . " §9secondes.");
                break;

            default:
                Server::getInstance()->broadcastMessage(self::PREFIX . "§9Restart : §f" . $this->type . " §9dans §f" . $this->second . " §9secondes.");
                break;

        }

        if($this->second-- === 0) {

            switch ($this->type) {

                case 'maintenance':
                    foreach (Server::getInstance()->getOnlinePlayers() as $player) {
                        $player->kick("Restart", self::PREFIX . "Maintenance nous nous excusons de la gène occasionnel");
                    }
                    Server::getInstance()->getConfigGroup()->setConfigBool("white-list", true);
                    break;

                default:
                    foreach (Server::getInstance()->getOnlinePlayers() as $player) {
                        $player->transfer(Server::getInstance()->getIp(), Server::getInstance()->getPort());
                    }
                    break;

            }

            Server::getInstance()->forceShutdown();

        }
    }
}