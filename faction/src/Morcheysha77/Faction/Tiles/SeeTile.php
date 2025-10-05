<?php


namespace Morcheysha77\Faction\Tiles;


use pocketmine\inventory\InventoryHolder;

use pocketmine\block\tile\{Container, ContainerTrait, Nameable, NameableTrait, Spawnable};

use pocketmine\nbt\tag\CompoundTag;

use Morcheysha77\Faction\Inventories\SeeInventory;
use Morcheysha77\Faction\Tiles\Interfaces\SeeInterface;

class SeeTile extends Spawnable implements InventoryHolder, Container, Nameable, SeeInterface
{

    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
    use ContainerTrait;

    /** @var SeeInventory $inventory */
    protected SeeInventory $inventory;

    /** @var string $target */
    protected string $target;

    /**
     * @return SeeInventory
     */
    public function getRealInventory(): SeeInventory
    {
        return $this->inventory;
    }

    /**
     * @return string
     */
    public function getDefaultName(): string
    {
        return "See";
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target = ""): void
    {
        $this->target = $target;
    }

    public function close(): void
    {
        if(!$this->isClosed()) {

            foreach($this->getInventory()->getViewers() as $viewer) {
                $viewer->removeCurrentWindow();
            }

            parent::close();
        }
    }

    /**
     * @return SeeInventory
     */
    public function getInventory(): SeeInventory
    {
        return $this->inventory;
    }

    /**
     * @param CompoundTag $nbt
     */
    public function readSaveData(CompoundTag $nbt): void
    {
        $this->loadName($nbt);
    }

    /**
     * @param CompoundTag $nbt
     */
    protected function writeSaveData(CompoundTag $nbt) : void
    {
        $this->saveName($nbt);
    }

    /**
     * @param CompoundTag $nbt
     */
    protected function addAdditionalSpawnData(CompoundTag $nbt): void
    {
        $this->addNameSpawnData($nbt);
    }
}