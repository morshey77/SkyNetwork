<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ / 
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /  
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |   
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Tasks;


use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use pocketmine\utils\Internet;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Prefix;

class RequestAsyncVote extends AsyncTask implements Prefix
{

    /** @var string $api */
    private string $api = "https://minecraftpocket-servers.com/api/";
    /** @var string $key */
    private string $key = "nsk7hLm3UVqClaPprM4IUcUW4IeUfxdgvg";
    /** @var string $name */
    private string $name;

    /**
     * RequestAsyncVote constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function onRun(): void
    {
        if (($o = Internet::getURL($this->api . "?object=votes&element=claim&key=" . $this->key . "&username="
                . str_replace(" ", "+", $this->name)))->getBody() === "1")
            Internet::getURL($this->api . "?action=post&object=votes&element=claim&key=" . $this->key
                . "&username=" . str_replace(" ", "+", $this->name));

        $this->setResult($o);
    }

    public function onCompletion(): void
    {

        $player = Server::getInstance()->getPlayerByPrefix($this->name);

        if($player instanceof FPlayer) $player->vote($this->getResult());
    }
}