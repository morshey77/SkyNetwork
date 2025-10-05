<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction;


use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;

use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;

use pocketmine\world\World;
use pocketmine\world\generator\GeneratorManager;

use pocketmine\item\ItemFactory;

use pocketmine\block\BlockFactory;
use pocketmine\block\tile\TileFactory;

use pocketmine\entity\EntityFactory;
use pocketmine\entity\EntityDataHelper;

use pocketmine\nbt\tag\CompoundTag;

use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\Managers\{Manager, SubCommandManager, TranslateManager};
use Morcheysha77\Faction\SubCommand\SubCommandMain;

use Morcheysha77\Faction\Tiles\{EnderSee, InvSee, Spawner};
use Morcheysha77\Faction\Entities\{Cow, Creeper, Egg, NPC, Sheep, Skeleton, Spider, Zombie};

use ReflectionClass;
use ReflectionException;

class Main extends PluginBase
{

    /** @var array<string, Manager> $managers */
    private array $managers = [];
    /** @var array<string, array> $info */
    public array $info = [];

    public function onLoad(): void
    {

        $generator = new GeneratorManager;

        foreach ([] as $name => $class) {
            $generator->addGenerator($class, $name, fn() => null, true);
        }
    }

    /**
     * @throws ReflectionException
     */
    public function onEnable(): void
    {

        $this->register(dirname(__FILE__) . "/Managers", "Manager");
        $this->register(dirname(__FILE__) . "/Blocks", "Block");
        $this->register(dirname(__FILE__) . "/Commands", "Command", [".", "..", "Properties"]);
        $this->register(dirname(__FILE__) . "/Events", "Event");
        $this->register(dirname(__FILE__) . "/Items", "Item", [".", "..", "Tool"]);
        $this->register(dirname(__FILE__) . "/Tasks/Every", "Task");
        $this->register(dirname(__FILE__) . "/Translates", "Translate");
        $this->register(dirname(__FILE__) . "/SubCommand", "SubCommand", [".", "..", "SubCommand", "SubCommandMain"]);

        $this->saveDefaultConfig();

        foreach (
            [
                "Cow" => Cow::class,
                "Creeper" => Creeper::class,
                "Egg" => Egg::class,
                "NPC" => Npc::class,
                "Sheep" => Sheep::class,
                "Skeleton" => Skeleton::class,
                "Spider" => Spider::class,
                "Zombie" => Zombie::class
            ]
            as $name => $entity) {

            $reflection = new ReflectionClass($entity);

            EntityFactory::getInstance()->register($entity, function(World $world, CompoundTag $nbt) use ($reflection): object {
                return $reflection->newInstance(EntityDataHelper::parseLocation($nbt, $world), $nbt);
            }, [$name, "minecraft:" . strtolower($name)], $reflection->getMethod("getNetworkTypeId"));

        }

        foreach (
            [
                "EnderSee" => EnderSee::class,
                "InvSee" => InvSee::class,
                "Spawner" => Spawner::class
            ]
            as $name => $tile) {

            TileFactory::getInstance()->register($tile, [$name, "minecraft:" . strtolower($name)]);

        }
    }

    public function onDisable(): void
    {

        $server = $this->getServer();

        foreach ($server->getOnlinePlayers() as $player) {
            if($player instanceof FPlayer) $player->transfer($server->getIp(), $server->getPort());
        }

        array_map(fn($manager) => $manager->disable(), array_values($this->managers));

    }

    /**
     * @param string $dir
     * @param string $type
     * @param array|string[] $banned
     * @throws ReflectionException
     */
    private function register(string $dir, string $type, array $banned = [".", ".."]): void
    {
        foreach (scandir($dir) as $file) {
            if(!in_array($file, $banned)) {
                if(is_dir($dir . "/" . $file)) $this->register($dir . "/" . $file, $type, $banned);
                else {
                    
                    $name = "\\" . str_replace([dirname(__FILE__), "/", ".php"], ["", "\\", ""], __NAMESPACE__ . $dir . "/" . $file);
                    
                    switch ($type) {
                        
                        case "Block":
                            BlockFactory::getInstance()->register(new $name(), true);
                            break;
                            
                        case "Command":
                            if (($class = new $name($this)) instanceof Command) {

                                $this->getServer()->getCommandMap()->register($this->getName(), $class);
                                PermissionManager::getInstance()->addPermission(new Permission($class->getPermission()));

                            }
                            break;
                            
                        case "Event":
                            $this->getServer()->getPluginManager()->registerEvents(new $name($this), $this);
                            break;
                            
                        case "Item":
                            ItemFactory::getInstance()->register(new $name(), true);
                            break;
                            
                        case "Manager":
                            $class = new $name($this);
                            $this->managers[$class->getName()] = $class;
                            break;
                        
                        case "Task":
                            $class = new $name($this);
                            $this->getScheduler()->scheduleRepeatingTask($class, $class->getEverySecond() * 20);
                            break;

                        case "Translate":
                            if(($manager = $this->getManagers("translate")) !== null AND $manager instanceof TranslateManager)
                                $manager->addTranslate(str_replace(".php", "", $file), new $name());
                            break;

                        case "SubCommand":
                            if(($manager = $this->getManagers("subcommand")) !== null AND $manager instanceof SubCommandManager) {

                                $class = new $name($this);

                                if($class instanceof SubCommandMain)
                                    $manager->addSubCommand(str_replace(["SubCommand", ".php"], "", $file), new $name($this));

                            }
                            break;

                    }
                }
            }
        }
    }

    /**
     * @param string $name
     * @return Manager|null
     */
    public function getManagers(string $name): ?Manager
    {
        return (isset($this->managers) AND isset($this->managers[$name])) ? $this->managers[$name] : null;
    }
}
