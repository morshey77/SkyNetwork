<?php


namespace Morcheysha77\Faction\Inventories;

use pocketmine\inventory\ContainerInventory;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

use Morcheysha77\Faction\Tiles\Tile;
use Morcheysha77\Faction\Tiles\Hopper as HopperTile;

class Hopper extends ContainerInventory
{

    /**
     * HopperInventory constructor.
     * @param HopperTile $tile
     */
    public function __construct(HopperTile $tile)
    {
        parent::__construct($tile);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return Tile::HOPPER;
    }

    /**
     * @return int
     */
    public function getDefaultSize(): int
    {
        return 5;
    }

    /**
     * @return int
     */
    public function getNetworkType(): int
    {
        return WindowTypes::HOPPER;
    }
}