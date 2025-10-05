<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\Server;
use pocketmine\player\Player;

class MentionManager extends Manager
{

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "mention";
    }

    /**
     * @return array
     */
    public function getAllPlayer(): array
    {
        return $this->plugin->getServer()->getOnlinePlayers();
    }

    /**
     * @return Player
     */
    public function getRandomPlayer(): Player
    {
        return Server::getInstance()->getOnlinePlayers()[mt_rand(0, count(Server::getInstance()->getOnlinePlayers()))];
    }
}