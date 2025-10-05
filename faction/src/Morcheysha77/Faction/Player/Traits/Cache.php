<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player\Traits;


use Morcheysha77\Faction\Tasks\QueryAsync;

trait Cache
{

    public function setCache(): void
    {

        $server = $this->getServer();
        $name = $this->getName();
        $count = count($server->getOnlinePlayers());

        $server->getAsyncPool()->submitTask(new QueryAsync(
            "Network",
            "SELECT * FROM player WHERE player = '" . strtolower($name) . "';",
            function(QueryAsync $self) {

                $result = $self->getResult();

                if(is_array($result)){

                    $this->setRank(strval($result["rank"]));
                    $this->setLang(strval($result["lang"]));
                    $this->setCoins(intval($result["coins"]));

                } else {

                    $this->setRank("Player");
                    $this->setLang("English");
                    $this->setCoins(0);

                }
            }
        ));

        $this->getServer()->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "SELECT * FROM info WHERE player = '" . strtolower($name) . "';",
            function(QueryAsync $self) {

                $result = $self->getResult();

                if(is_array($result)){

                    $faction = explode("_", strval($result["faction"]));

                    $this->setFaction($faction[0]);
                    $this->setFactionRank($faction[1]);
                    $this->setHomes(strval($result["homes"]));
                    $this->setMoney(intval($result["money"]));
                    $this->setKill(intval($result["kill"]));
                    $this->setDeath(intval($result["death"]));
                    $this->setKillStreak(intval($result["killstreak"]));
                    $this->setPoints(intval($result["points"]));

                } else {

                    $this->setFaction("No Faction");
                    $this->setFactionRank("Player");
                    $this->setHomes("");
                    $this->setMoney(0);
                    $this->setKill(0);
                    $this->setDeath(0);
                    $this->setKillStreak(0);
                    $this->setPoints(0);

                }

                $this->addScoreBoard();
                $this->setPermissions();
            }
        ));

        array_map(function ($p) use ($name, $count) {
            if($p instanceof $this AND $p->getName() !== $name)
                $p->setScoreBoard(4, " §9Online: §f" . $count);
        }, $server->getOnlinePlayers());

    }

    public function delCache(): void
    {

        $server = $this->getServer();
        $name = $this->getName();
        $count = count($server->getOnlinePlayers());

        $this->removeScoreBoard();
        $server->getAsyncPool()->submitTask(new QueryAsync(
            "Network",
            "REPLACE INTO player(`player`, `rank`, `lang`, `coins`, `ip`, `port`) VALUES ('"
            . strtolower($name) . "','" . $this->getRank() . "','" . $this->getLang() . "','"
            . $this->getCoins() . "','" . $this->getNetworkSession()->getIp() . "','" . $this->getNetworkSession()->getPort() . "');",
            function(){}
        ));
        $server->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "REPLACE INTO info(`player`, `faction`, `homes`, `money`, `kill`, `death`, `killstreak`, `points`) VALUES ('"
            . strtolower($name) . "','" . $this->getSaveFaction() . "','" . $this->getSaveHomes() . "','" . $this->getMoney()
            . "','" . $this->getKill() . "','" . $this->getDeath() . "','" . $this->getKillStreak() . "','" . $this->getPoints() . "');",
            function(){}
        ));

        array_map(function ($p) use ($name, $count) {
            if($p instanceof $this AND $p->getName() !== $name)
                $p->setScoreBoard(4, " §9Online: §f" . ($count - 1));
        }, $server->getOnlinePlayers());

    }

}