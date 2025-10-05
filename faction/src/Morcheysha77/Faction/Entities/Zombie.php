<?php

namespace Morcheysha77\Faction\Entities;

use pocketmine\entity\Zombie as Zb;
use pocketmine\item\Item;

class Zombie extends Zb
{

    /** @var float $height */
    public $height = 1.95;
    /** @var float $width */
    public $width = 0.6;

    /**
     * @return array
     */
    public function getDrops(): array
    {
        return [
            Item::get(Item::ROTTEN_FLESH, 0, mt_rand(0, 2))
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
