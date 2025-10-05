<?php

namespace skynetwork\core\traits;

use skynetwork\core\tasks\RepeatingTask;
use skynetwork\core\enums\RecursiveRegisterType;
use pocketmine\block\BlockFactory;
use pocketmine\command\Command;
use pocketmine\item\ItemFactory;
use ReflectionException;

trait RecursiveRegisterTrait
{

    /**
     * @param string $dirname
     * @param string $dir
     * @param RecursiveRegisterType $type 
     * @param array|string[] $banned
     * @throws ReflectionException
     */
    public function register(string $dirname, string $dir, RecursiveRegisterType $type, array $banned = ['.', '..']): void
    {
        foreach (scandir($dir) as $file) {
            if(!in_array($file, $banned)) {
                if(is_dir($dir . '/' . $file)) $this->register($dirname, $dir . '/' . $file, $type, $banned);
                else {

                    $name = '\\' . str_replace([$dirname, '/', '.php'], ['', '\\', ''],   $dir . '/' . $file);

                    switch ($type) {

                        /**
                        case RecursiveRegisterType::BLOCK:
                            BlockFactory::getInstance()->register(new $name(), true);
                            break;
                         **/

                        case RecursiveRegisterType::COMMAND:
                            $class = new $name($this);

                            if ($class instanceof Command)
                                $this->getServer()->getCommandMap()->register($this->getName(), $class);
                            break;

                        case RecursiveRegisterType::LISTENER:
                            $this->getServer()->getPluginManager()->registerEvents(new $name($this), $this);
                            break;

                            /**
                        case RecursiveRegisterType::ITEM:
                            ItemFactory::getInstance()->register(new $name(), true);
                            break;
                             **/

                        case RecursiveRegisterType::MANAGER:
                            if(property_exists($this, 'managers')) {

                                $class = new $name($this);
                                $this->managers[$class->getName()] = $class;

                            }
                            break;

                        case RecursiveRegisterType::REPEATING_TASK:
                            $class = new $name($this);
                            if ($class instanceof RepeatingTask)
                                $this->getScheduler()->scheduleRepeatingTask($class, $class->getEverySecond() * 20);
                            break;

                    }
                }
            }
        }
    }
}