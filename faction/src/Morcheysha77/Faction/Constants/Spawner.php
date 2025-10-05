<?php

namespace Morcheysha77\Faction\Constants;


use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

interface Spawner extends Prefix 
{

    public const
        DEFAULT_NAME = "Monster Spawner",
        DEFAULT_ID = 0,
        PRE = "Spawner à ",
        NAME =
        [
            self::PRE . "Vache" => EntityIds::COW,
            self::PRE . "Mouton" => EntityIds::SHEEP,
            self::PRE . "Zombie" => EntityIds::ZOMBIE,
            self::PRE . "Creeper" => EntityIds::CREEPER,
            self::PRE . "Squelette" => EntityIds::SKELETON,
            self::PRE . "Araignée" => EntityIds::SPIDER,
        ],
        ID =
        [
            EntityIds::COW => self::PRE . "Vache",
            EntityIds::SHEEP => self::PRE . "Mouton",
            EntityIds::ZOMBIE => self::PRE . "Zombie",
            EntityIds::CREEPER => self::PRE . "Creeper",
            EntityIds::SKELETON => self::PRE . "Squelette",
            EntityIds::SPIDER => self::PRE . "Araignée",
        ];
}