<?php

namespace skynetwork\core\libs\mysql;

use skynetwork\core\tasks\ClosureAsyncTask;
use mysqli;
use mysqli_result;
use pocketmine\Server;

class Database extends mysqli
{

    /**
     * @param string|null $hostname
     * @param string|null $username
     * @param string|null $password
     * @param string|null $database
     * @param int|null $port
     * @param string|null $socket
     */
    public function __construct(
        protected ?string $hostname = null, protected ?string $username = null,
        protected ?string $password = null, protected ?string $database = null,
        protected ?int $port = null, protected ?string $socket = null
    )
    {
        parent::__construct($hostname, $username, $password, $database, $port, $socket);

        if ($this->connect_error)
            die('Connection failed: ' . $this->connect_error);

    }

    /**
     * @param Server $server
     * @param string $query
     * @return bool
     */
    public function insert(Server $server, string $query): bool
    {
        $server->getAsyncPool()->submitTask(new ClosureAsyncTask(function (ClosureAsyncTask $task) use ($query) {
            $task->setResult($this->query($query) instanceof mysqli_result);
        }, function (ClosureAsyncTask $task) use (&$r){
            $r = $task->getResult();
        }));

        return $r;
    }

    /**
     * @param Server $server
     * @param string $query
     * @return array|bool|null
     */
    public function fetch(Server $server, string $query): array|bool|null
    {
        $server->getAsyncPool()->submitTask(new ClosureAsyncTask(function (ClosureAsyncTask $task) use ($query) {
            $task->setResult($this->query($query)->fetch_assoc());
        }, function (ClosureAsyncTask $task) use (&$r){
            $r = $task->getResult();
        }));

        return $r;
    }

    /**
     * @param Server $server
     * @param string $query
     * @return array
     */
    public function fetchAll(Server $server, string $query): array
    {
        $server->getAsyncPool()->submitTask(new ClosureAsyncTask(function (ClosureAsyncTask $task) use ($query) {
            $task->setResult($this->query($query)->fetch_all());
        }, function (ClosureAsyncTask $task) use (&$r){
            $r = $task->getResult();
        }));

        return $r;
    }
}