<?php

namespace skynetwork\game\managers\map;

use skynetwork\game\Core;
use skynetwork\game\tasks\MapRemoveTask;
use pocketmine\world\{World, WorldManager};

use skynetwork\game\managers\{game\Game, game\GameState};

use ZipArchive;

class Map
{

    /** @var World|null $world */
    protected ?World $world = null;

    /**
     * @param Game $game
     * @param WorldManager $worldManager
     * @param string $mapPath
     */
    public function __construct(protected Game $game, protected WorldManager $worldManager, protected string $mapPath) {}

    /**
     * @return World|null
     */
    public function getWorld(): ?World
    {
        return $this->world;
    }

    public function setWorld(World $world): void
    {
        $this->world = $world;
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $path = $this->worldManager->getDefaultWorld()->getServer()->getDataPath()
            . 'worlds' . DIRECTORY_SEPARATOR . $this->game->getUUID();

        @mkdir($path);

        $zip = new ZipArchive();
        $zip->open($this->mapPath);
        $zip->extractTo($path);
        $zip->close();

        unset($zip);

        do {
            $this->worldManager->loadWorld($this->game->getUUID());
            $world = $this->worldManager->getWorldByName($this->game->getUUID());
        } while ($world === null);

        $world->setAutoSave(false);

        $this->game
            ->setState(GameState::WAITING)
            ->getArena()->getMap()->setWorld($world);
    }

    /**
     * @return void
     */
    public function destroy(): void
    {

        do {
            $this->worldManager->unloadWorld($this->getWorld(), true);
            $this->world = $this->worldManager->getWorldByName($this->game->getUUID());
        } while ($this->world !== null);

        $server = $this->worldManager->getDefaultWorld()->getServer();
        $server->getAsyncPool()->submitTask(
            new MapRemoveTask($server->getDataPath() . 'worlds' . DIRECTORY_SEPARATOR . $this->game->getUUID())
        );
    }
}