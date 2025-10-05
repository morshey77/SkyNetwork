<?php

namespace skynetwork\core\tasks;

use Closure;
use DaveRandom\CallbackValidator\{CallbackType, ReturnType};
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;
use ReflectionException;

class ClosureAsyncTask extends AsyncTask
{

    /**
     * @param Closure $closure
     * @param Closure|null $closureCompletion
     */
    public function __construct(protected Closure $closure, protected ?Closure $closureCompletion = null)
    {

        Utils::validateCallableSignature(new CallbackType(new ReturnType()), $closure);

        if ($closureCompletion !== null)
            Utils::validateCallableSignature(new CallbackType(new ReturnType()), $closureCompletion);
    }

    public function onRun(): void
    {
        ($this->closure)();
    }

    public function onCompletion(): void
    {
        if ($this->closureCompletion !== null)
            ($this->closureCompletion)();
    }
}