<?php

namespace skynetwork\game;

use pocketmine\plugin\PluginBase;

use skynetwork\game\managers\{GameManager, game\Game};
use skynetwork\game\listeners\{BlockListener, EntityListener, GameListener, InventoryListener, PlayerListener};

use skynetwork\game\commands\ListCommand;

use DaveRandom\CallbackValidator\{CallbackType, ReturnType};

use Exception;
use Closure;
use pocketmine\utils\SingletonTrait;

class Core extends PluginBase
{

    use SingletonTrait;

    /** @var GameManager|null $gameManager */
    protected ?GameManager $gameManager = null;

    /** @var Closure|null $createGame */
    protected ?Closure $createGame = null;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {

        new BlockListener($this);
        new EntityListener($this);
        new GameListener($this);
        new InventoryListener($this);
        new PlayerListener($this);

        new ListCommand($this);

    }

    protected function onDisable(): void
    {
        $this->gameManager->destroy();
    }

    /**
     * @return void
     */
    protected function makeGameManager(): void
    {
        if($this->createGame !== null)
            $this->gameManager = new GameManager($this);
    }

    /**
     * @return GameManager|null
     */
    public function getGameManager(): ?GameManager
    {
        return $this->gameManager ?? null;
    }

    /**
     * @param Closure|null $createGame
     * @throws Exception
     */
    public function setCreateGame(?Closure $createGame): void
    {
        if($this->createGame !== null)
            throw new Exception('CreateGame is already set');
        if($createGame !== null)
            if(!(new CallbackType(new ReturnType(Game::class)))->isSatisfiedBy($createGame))
                throw new Exception('\$createGame must be a function that returns a game instance');

        $this->createGame = $createGame;
        $this->makeGameManager();

    }

    /**
     * @return Closure|null
     */
    public function getCreateGame(): ?Closure
    {
        return $this->createGame ?? null;
    }
}