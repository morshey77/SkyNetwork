<?php

namespace Morcheysha77\Faction\Tasks;


use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\SocketManager;

use Morcheysha77\Faction\Constants\Command;
use Morcheysha77\Faction\Constants\Socket\ServerWrite;

class SocketAsync extends AsyncTask implements ServerWrite, Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * SocketAsync constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onRun(): void
    {
        if (($manager = $this->plugin->getManagers("socket")) !== null) {
            if($manager instanceof SocketManager) {
                while (true) {
                    if(($read = $manager->read()) !== "") {

                        $read = json_decode($read);

                        if(is_array($read)) {

                            $this->setResult($read);
                            break;

                        }
                    }
                }
            }
        }
    }

    public function onCompletion(): void
    {

        foreach ($this->getResult() as $id => $data) {
            switch ($id) {

                case self::SEND_BROADCAST_MESSAGE_NETWORK:
                    Server::getInstance()->broadcastMessage($data);
                    break;
                case self::SEND_BROADCAST_POPUP_NETWORK:
                    Server::getInstance()->broadcastPopup($data);
                    break;
                case self::SEND_BROADCAST_TIP_NETWORK:
                    Server::getInstance()->broadcastTip($data);
                    break;
                case self::SEND_BROADCAST_TITLE_NETWORK:
                    Server::getInstance()->broadcastTitle($data);
                    break;

                default:
                    $this->plugin->getLogger()->error(self::PREFIX . "Unknown ID(0x" . dechex($id) . ") from ServerSocket Write !");

            }
        }

        Server::getInstance()->getAsyncPool()->submitTask(new self($this->plugin));

    }
}