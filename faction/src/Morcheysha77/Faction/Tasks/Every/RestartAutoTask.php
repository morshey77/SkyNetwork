<?php


namespace Morcheysha77\Faction\Tasks\Every;


use pocketmine\scheduler\Task;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Tasks\RestartTask;

class RestartAutoTask extends Task
{

    /** @var Main $plugin */
    private Main $plugin;
    /** @var int $second */
    private int $second;

    /**
     * RestartAutoTask constructor.
     * @param Main $plugin
     */
     public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        $this->second = 3600 * 8;
    }

    /**
     * @return int
     */
    public function getEverySecond(): int
    {
        return 3600 * 2;
    }

    public function onRun(): void
    {
        if($this->second <= 0) {

            $this->plugin->getScheduler()->scheduleRepeatingTask(new RestartTask(5, "automatic"), 20);
            $this->getHandler()->cancel();

        }

        $this->second -= $this->getEverySecond();

    }
}