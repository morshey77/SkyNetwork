<?php

namespace Morcheysha77\Faction\Entities;

use pocketmine\entity\Animal;
use pocketmine\item\Item;

class Sheep extends Animal
{

    const NETWORK_ID = self::SHEEP;

    /** @var float $height */
    public $height = 1.3;
    /** @var float $width */
    public $width = 0.9;

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "Sheep"; 
    }

    /**
     * @return array
     */
    public function getDrops(): array
    {
        return [
            Item::get(Item::COOKED_MUTTON, 0, mt_rand(1, 3))
            ];
    }

    /**
     * @return int
     */
    public function getXpDropAmount(): int
    {
        return mt_rand(1, 3);
    }
}
