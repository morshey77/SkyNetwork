<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ / 
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /  
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |   
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Player;


use pocketmine\Server;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Tasks\QueryAsync;

use Morcheysha77\Faction\Constants\Prefix;
use Morcheysha77\Faction\UtilsTraits\Date;

class PlayerLogin implements Listener, Prefix
{

    use Date;

    /**
     * @param PlayerLoginEvent $event
     */
    public function PlayerLoginEvent(PlayerLoginEvent $event): void
    {

        $player = $event->getPlayer();

        if($player instanceof FPlayer) {

            $server = $player->getServer();

            if(!$server->isWhitelisted($player->getName()))
                $player->kick("whitelist", self::COMMAND . "\n§f"
                    . $server->getConfigGroup()->getConfigString("name") . " §9is whitelisted");

            $server->getAsyncPool()->submitTask(new QueryAsync(
                "Faction",
                "SELECT * FROM ban WHERE player = '" . strtolower($player->getName()) . "';",
                function(QueryAsync $self, Server $server) use ($event, $player) {

                    if(is_array($info = $self->getResult())) $this->banExecute($event, $info);
                    else {

                        $server->getAsyncPool()->submitTask(new QueryAsync(
                            "Faction",
                            "SELECT * FROM ban WHERE ip = '" . $player->getNetworkSession()->getIp() . "';",
                            function(QueryAsync $self) use ($event, $player) {
                                if(is_array($info = $self->getResult())) $this->banExecute($event, $info);
                            }
                        ));
                    }
                }
            ));

        }
    }

    /**
     * @param PlayerLoginEvent $event
     * @param array $info
     */
    private function banExecute(PlayerLoginEvent $event, array $info): void
    {

        $player = $event->getPlayer();
        $server = $player->getServer();

        if($info["time"] === -1 OR $info["time"] - time() > 0) {

            $player->kick("anticheat",
                self::COMMAND . "\n§9You were banned from §f" . $server->getConfigGroup()->getConfigString("name")
                . "\n§9Staff : §f" . $info["staff"] . "\n§9Reason : §f" . $info["reason"]
                . "\n§9Duration : §f" . $this->format($info["time"] === -1 ? $info["time"] : $info["time"] - time())
            );

        } else {

            $server->getAsyncPool()->submitTask(new QueryAsync(
                "Faction",
                "DELETE FROM ban WHERE player = '" . strtolower($player->getName()) . "';",
                function(){}
            ));

        }
    }
}
