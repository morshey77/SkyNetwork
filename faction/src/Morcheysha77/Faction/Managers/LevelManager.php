<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\Server;

class LevelManager extends Manager
{

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "level";
    }

    public function init(): void
    {
        foreach(scandir(Server::getInstance()->getDataPath() . "/worlds/") as $world){
            if($world !== "." && $world !== ".." ){
                if(!Server::getInstance()->getWorldManager()->isWorldLoaded($world))
                    Server::getInstance()->getWorldManager()->loadWorld($world);
            }
        } 
    }
}