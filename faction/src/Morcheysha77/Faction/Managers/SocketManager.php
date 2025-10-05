<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\Server;

use Morcheysha77\Faction\Constants\Command;
use Morcheysha77\Faction\Tasks\SocketAsync;

use Socket, Exception;

class SocketManager extends Manager implements Command
{

    private const CONNECTION = ["127.0.0.1", 4];

    /** @var Socket|false $socket */
    private Socket|false $socket = false;


    /**
     * @throws Exception
     */
    public function init(): void
    {
        if (($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
            throw new Exception("Failed to create socket (". socket_strerror(socket_last_error()) . ")\n");
        if (socket_connect($this->socket, ...self::CONNECTION) === false)
            throw new Exception("Failed to connect socket (". socket_strerror(socket_last_error()) . ")\n");

        socket_set_nonblock($this->socket);
        $this->plugin->getLogger()->info(self::PREFIX . "Socket Client is started !");

        Server::getInstance()->getAsyncPool()->submitTask(new SocketAsync($this->plugin));

    }

    /**
     * @param array $array
     * @return bool
     */
    public function write(array $array = []): bool
    {

        $data = json_encode($array);

        if (($error = socket_write($this->socket, $data, strlen($data))) === false)
            $this->plugin->getLogger()->error("Failed to write socket (". socket_strerror(socket_last_error()) . ")\n");

        return $error !== false;
    }

    /**
     * @return string
     */
    public function read(): string
    {
        if (($read = socket_read($this->socket, 2048)) === false OR $read === "")
            $this->plugin->getLogger()->error("Failed to read socket (". socket_strerror(socket_last_error()) . ")\n");

        return is_string($read) ? $read : "";
    }

    public function disable(): void
    {
        socket_close($this->socket);
    }
}