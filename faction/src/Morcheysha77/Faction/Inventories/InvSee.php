<?php


namespace Morcheysha77\Faction\Inventories;

use pocketmine\inventory\ContainerInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

use Morcheysha77\Faction\Tiles\InvSee as InvSeeTile;

class InvSee extends ContainerInventory implements InventoryHolder
{

    /** @var InvSeeTile $tile */
    private InvSeeTile $tile;

    /**
     * InvSee constructor.
     * @param InvSeeTile $tile
     */
    public function __construct(InvSeeTile $tile)
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
        return InvSeeTile::SIZE;
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
     * @return InvSeeTile
     */
    public function getTile(): InvSeeTile
    {
        return $this->tile;
    }
}