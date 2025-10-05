<?php

namespace skynetwork\core\tasks;

use pocketmine\scheduler\Task;

abstract class RepeatingTask extends Task
{

    /**
     * @return int
     */
    abstract public function getEverySecond(): int;

    /**
     * @return void
     */
    public function onRun(): void {}
}