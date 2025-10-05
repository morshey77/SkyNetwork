<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player;


use pocketmine\player\Player;

use Morcheysha77\Faction\Player\Traits\{
    Cache, Chat, Coins, CombatLogger, Death, Faction, Home, Info, KD, Kill, KillStreak, Messages, Lang, Money, Permissions, Points, Rank, Scoreboard
};

use Morcheysha77\Faction\Constants\Prefix;
use pocketmine\Server;

class FPlayer extends Player implements Prefix
{

    use Cache, Chat, Coins, CombatLogger, Death, Faction, Home, Info, KD, Kill, KillStreak, Messages, Lang, Money, Permissions, Points, Rank, Scoreboard;

    /** @var bool $chestfinder */
    public bool $chestfinder = false;
    /** @var bool $seechunk */
    public bool $seechunk = false;
    
    public function vote(string $result): void
    {
        switch($result){

            case "0":
                $this->sendMessage($this->translate("not_voted"));
                break;

            case "1":
                $this->addCoins($coins = mt_rand(5, 10));
                $this->sendMessage($this->translate("vote_already_reclaim", [$coins]));
                $this->getServer()->broadcastMessage(self::COMMAND . "§f" . ucfirst($this->getName()) . " §9just voted !");
                break;

            default:
                $this->sendMessage($this->translate("vote_already_reclaim"));
                break;

        }
    }
}
