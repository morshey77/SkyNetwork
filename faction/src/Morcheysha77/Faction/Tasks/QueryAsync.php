<?php

namespace Morcheysha77\Faction\Tasks;


use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use Morcheysha77\Faction\Constants\MySql;

use mysqli;
use mysqli_result;

class QueryAsync extends AsyncTask implements MySql
{

    /** @var string $base */
    private string $base;
    /** @var string $message */
    private string $message;
    /** @var callable $callable */
    private $callable;

    /**
     * QueryAsync constructor.
     * @param string $base
     * @param string $message
     * @param callable $callable
     */
    public function __construct(string $base, string $message, callable $callable)
    {
        
        $this->base = $base;
        $this->message = $message;
        $this->callable = $callable;
        
    }

    public function onRun(): void
    {

        $mysql = new MySQLi(self::HOST, self::USERS[$this->base], self::PASSWD[$this->base], self::BASES[$this->base]);
        $q = $mysql->query($this->message);
        if($q instanceof MySQLi_result) $this->setResult($q->fetch_array(MYSQLI_ASSOC));
        else $this->setResult($q);
        $mysql->close();

    }

    public function onCompletion(): void
    {
        call_user_func($this->callable, $this, Server::getInstance());
    }
}