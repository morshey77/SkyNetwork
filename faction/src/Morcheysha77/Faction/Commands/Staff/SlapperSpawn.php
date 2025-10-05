<?php


namespace Morcheysha77\Faction\Commands\Staff;


use pocketmine\command\CommandSender;

use pocketmine\entity\EntityFactory;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;

use Morcheysha77\Faction\Commands\Properties\Command;

class SlapperSpawn extends Command
{

    /**
     * SlapperSpawn constructor.
     */
    public function __construct()
    {
        parent::__construct("slapperspawn", "Allows to spawn teleport slapper", "slapperspawn <world>");
        $this->setPermission("pocketmine.command.slapperspawn");

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {

        if(($s = $this->isPlayer($sender)) !== null) {
            if($this->testPermission($s)) {
                if(empty($args) OR empty($args[0])) $s->sendMessage($this->getUsage());
                else {
                    if($s->getServer()->getWorldManager()->isWorldLoaded($args[0]))
                        $s->getServer()->getWorldManager()->loadWorld($args[0]);
                    if($s->getServer()->getWorldManager()->getWorldByName($args[0]) === null)
                        $s->sendMessage($s->translate("world_not_exist", [$args[0]]));
                    else {

                        EntityFactory::getInstance()->createFromData($s->getWorld(), CompoundTag::create()
                            ->setTag("Pos", new ListTag([
                                new DoubleTag($s->getLocation()->getX()),
                                new DoubleTag($s->getLocation()->getY()),
                                new DoubleTag($s->getLocation()->getZ())
                            ]))
                            ->setTag("Motion", new ListTag([
                                new DoubleTag($s->getMotion()->getX()),
                                new DoubleTag($s->getMotion()->getY()),
                                new DoubleTag($s->getMotion()->getZ())
                            ]))
                            ->setTag("Rotation", new ListTag([
                                new FloatTag($s->getLocation()->getYaw()),
                                new FloatTag($s->getLocation()->getPitch())
                            ]))
                            ->setTag("Skin", CompoundTag::create()
                                ->setString("Name", $s->getSkin()->getSkinId())
                                ->setByteArray("Data", $s->getSkin()->getSkinData())
                                ->setByteArray("CapeData", $s->getSkin()->getCapeData())
                                ->setString("GeometryName", $s->getSkin()->getGeometryName())
                                ->setByteArray("GeometryData", $s->getSkin()->getGeometryData())
                            )
                            ->setString("callback", base64_encode(
                                "\$name = $args[0];\$damager = \$source->getDamager();"
                                . "if(\$damager instanceof FPlayer) \{\$server = \$damager->getServer();if(\$server->getWorldManager()->isWorldLoaded(\$name))"
                                . " \$server->getWorldManager()->loadWorld(\$name);\$world = \$server->getWorldManager()->getWorldByName(\$name);"
                                . "if(\$server->getWorldManager()->getWorldByName(\$name) === null)\$damager->sendMessage(self::PREFIX . \"The Level "
                                . "\" . \$name . \" doesn't exist !\");else \$damager->teleport(\$world->getSafeSpawn());}}"
                            ))
                        )?->spawnToAll();
                    }
                }
            }
        }

        return true;

    }
}