<?php

namespace Morcheysha77\Faction\Entities;

use pocketmine\entity\Monster;
use pocketmine\item\Item;

class Spider extends Monster
{

    const NETWORK_ID = self::SPIDER;

    /** @var float $height */
    public $height = 1.4;
    /** @var float $width */
    public $width = 0.9;

    /**
     * @return string
     */
    public function getName() : string {
        return "Spider";
    }

    /**
     * @return array
     */
    public function getDrops(): array
    {
        return [
            Item::get(Item::STRING, 0, mt_rand(0, 2))
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
