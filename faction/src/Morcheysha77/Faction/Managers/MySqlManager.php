<?php


namespace Morcheysha77\Faction\Managers;

use Morcheysha77\Faction\Tasks\QueryAsync;

class MySqlManager extends Manager
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return "mysql";
    }
    
    public function init(): void 
    {

        $this->plugin->getServer()->getAsyncPool()->submitTask(new QueryAsync(
            "Network",
            "CREATE TABLE IF NOT EXISTS player(`player` VARCHAR(30) PRIMARY KEY, `rank` VARCHAR(30), `lang` VARCHAR(30), `coins` INT, `ip` VARCHAR(20), `port` INT);",
            function(){}
        ));
        $this->plugin->getServer()->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "CREATE TABLE IF NOT EXISTS info(`player` VARCHAR(30) PRIMARY KEY, `faction` TEXT, `homes` TEXT, `money` INT, `kill` INT, `death` INT, `killstreak` INT, `points` INT);",
            function(){}
        ));
        $this->plugin->getServer()->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "CREATE TABLE IF NOT EXISTS faction(`faction` VARCHAR(30) PRIMARY KEY, `money` INT, `power` INT, `allies` TEXT, `members` TEXT, `home` TEXT , `claims` TEXT);",
            function(){}
        ));
        $this->plugin->getServer()->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "CREATE TABLE IF NOT EXISTS ban(`player` VARCHAR(30) PRIMARY KEY, `time` INT, `reason` TEXT, `staff` VARCHAR(30), `ip` VARCHAR(30));",
            function(){}
        ));

    }
}