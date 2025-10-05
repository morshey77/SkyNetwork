<?php /** @noinspection PhpUnused */

namespace skynetwork\game\managers\arena;

use pocketmine\world\Position;
use pocketmine\world\WorldManager;

use skynetwork\game\managers\game\Game;
use skynetwork\game\managers\map\Map;

class Arena
{

    /** @var Map $map */
    protected Map $map;

    /**
     * @param Game $game
     * @param WorldManager $worldManager
     * @param string $mapPath
     * @param array $spawnsPosition
     * @param array $waitPosition
     *
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(Game $game, WorldManager $worldManager, protected string $mapPath, protected array $spawnsPosition,
        protected array $waitPosition
    )
    {
        $this->map = new Map($game, $worldManager, $this->mapPath);
    }

    public function getMap(): Map
    {
        return $this->map;
    }

    /**
     * @return Position
     */
    public function getWaitPosition(): Position
    {
        return new Position($this->waitPosition['x'] ?? 0, $this->waitPosition['y'] ?? 0, $this->waitPosition['z'] ?? 0, $this->getMap()->getWorld());
    }

    /**
     * @param string $key
     * @return Position
     */
    public function getSpawnPosition(string $key): Position
    {

        $position = $this->spawnsPosition[$key];

        return new Position($position['x'] ?? 0, $position['y'] ?? 0, $position['z'] ?? 0, $this->map->getWorld());
    }
}