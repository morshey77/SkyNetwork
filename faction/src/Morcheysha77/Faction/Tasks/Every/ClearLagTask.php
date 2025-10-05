<?php


namespace Morcheysha77\Faction\Tasks\Every;


use pocketmine\Server;

use pocketmine\entity\Living;
use pocketmine\entity\Human;
use pocketmine\entity\object\ItemEntity;

use pocketmine\scheduler\Task;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Constants\Command as CommandConstant;

class ClearLagTask extends Task implements CommandConstant
{

    /** @var Main $plugin */
    private Main $plugin;
    /** @var int $second */
    private int $second;
    /** @var int $start */
    private int $start;
    /** @var array<int> $times */
    private array $times;

    /**
     * ClearLagTask constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        $this->plugin = $plugin;
        $this->second = 600;
        $this->start = 600;
        $this->times = [300, 30, 15, 10, 5, 3, 2, 1];

    }

    /**
     * @return int
     */
    public function getEverySecond(): int 
    {
        return 1;
    }

    public function onRun(): void
    {

        if(--$this->second === 0) {
            
            $this->second = $this->start;
            $count = 0;

            foreach(Server::getInstance()->getWorldManager()->getWorlds() as $world) {
                foreach($world->getEntities() as $entity) {
                    if(!$entity instanceof Human AND ($entity instanceof Living OR $entity instanceof ItemEntity)) {

                        $entity->flagForDespawn();
                        $count++;

                    }
                }
            }

            $this->plugin->getServer()->broadcastMessage(self::PREFIX .  "Suppression de §f" . $count .  " §9entities");

        } elseif(in_array($this->second, $this->times))
            $this->plugin->getServer()->broadcastMessage(self::PREFIX .  "ClearLag dans §f" . $this->formatDate($this->second));
    }

    /**
     * @param int $t
     * @return string
     */
    private function formatDate(int $t): string 
    {
        if(floor($t / 60) > 0 AND $t % 60 === 0) 
            if(ceil($t % 60 === 0))
                return floor($t / 60) . " §9minute(s).";
            else
                return floor($t / 60) . " §9minute(s) §f" . ceil($t % 60) . " §9second(s).";
        else
            return ceil($t) . " §9second(s).";
    }
}