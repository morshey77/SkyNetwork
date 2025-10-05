<?php

namespace Morcheysha77\Faction\Entities;

use pocketmine\entity\Monster;
use pocketmine\item\Item;

class Creeper extends Monster
{

    const NETWORK_ID = self::CREEPER;

    /** @var float $height */
    public $height = 1.7;
    /** @var float $width */
    public $width = 0.6;

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "Creeper";
    }

    /**
     * @return array
     */
    public function getDrops(): array
    {
        return [
            Item::get(Item::GUNPOWDER, 0, mt_rand(0, 2))
            ];
    }

    /**
     * @return int
     */
    public function getXpDropAmount(): int
    {
        return 5;
    }
}
