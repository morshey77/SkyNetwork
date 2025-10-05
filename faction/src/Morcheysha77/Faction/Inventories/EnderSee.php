<?php


namespace Morcheysha77\Faction\Inventories;

use pocketmine\inventory\SimpleInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

use Morcheysha77\Faction\Tiles\EnderSee as EnderSeeTile;

class EnderSee extends SimpleInventory implements InventoryHolder
{

    /** @var EnderSeeTile $tile */
    private EnderSeeTile $tile;

    /**
     * EnderSee constructor.
     * @param EnderSeeTile $tile
     */
    public function __construct(EnderSeeTile $tile)
    {

        parent::__construct($tile);
        $this->tile = $tile;

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->tile->getName();
    }

    /**
     * @return int
     */
    public function getDefaultSize(): int
    {
        return EnderSeeTile::SIZE;
    }

    /**
     * @return int
     */
    public function getNetworkType(): int
    {
        return WindowTypes::CONTAINER;
    }

    /**
     * @return $this
     */
    public function getInventory(): self
    {
        return $this;
    }

    /**
     * @return EnderSeeTile
     */
    public function getTile(): EnderSeeTile
    {
        return $this->tile;
    }
}