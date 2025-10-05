<?php /** @noinspection PhpUnused */

namespace skynetwork\game\managers\team;

use pocketmine\player\Player;

use skynetwork\core\managers\ArrayManager;
use skynetwork\game\managers\game\Game;

use Exception;

class Team extends ArrayManager
{

    use TeamBroadcast;

    /**
     * @param int $minPlayers
     * @param int $maxPlayers
     * @param int $key
     * @param Game|null $game
     */
    public function __construct(protected int $minPlayers, protected int $maxPlayers, protected int $key, protected ?Game $game = null) {}


    /**
     * @param object $obj
     * @param string $key
     * @return void
     * @throws Exception
     */
    public function add(object $obj, string $key = ''): void
    {
        if (!$obj instanceof Player)
            throw new Exception('Team::add() - Team can only add Player objects!');

        parent::add($obj, $obj->getUniqueId()->toString());
    }

    /**
     * @return int
     *
     * @noinspection PhpUnused
     */
    public function getMinPlayers(): int
    {
        return $this->minPlayers;
    }

    /**
     * @return int
     */
    public function getMaxPlayers(): int
    {
        return $this->maxPlayers;
    }

    /**
     * @return int
     */
    public function getKey(): int
    {
        return $this->key;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     */
    public function setGame(Game $game): void
    {
        $this->game = $game;
    }

    /**
     * @return bool
     */
    public function isFull(): bool
    {
        return count($this->elements) >= $this->maxPlayers;
    }

    /**
     * @return bool
     */
    public function canStarted(): bool
    {
        return count($this->elements) >= $this->minPlayers;
    }
}