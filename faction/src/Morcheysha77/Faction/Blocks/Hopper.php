<?php


namespace Morcheysha77\Faction\Blocks;


use pocketmine\Server;

use pocketmine\block\Hopper as Hp;
use pocketmine\block\tile\Hopper as HopperTile;
use pocketmine\block\tile\Container;

use pocketmine\block\inventory\DoubleChestInventory;

use pocketmine\item\Item;
use pocketmine\entity\object\ItemEntity;

use pocketmine\math\Facing;

class Hopper extends Hp
{

    public function onScheduledUpdate(): void
    {

        $tile = $this->getPosition()->getWorld()->getTile($this->getPosition()->asVector3());

        if($tile instanceof HopperTile) {
            if((Server::getInstance()->getTick() % 8) == 0) {
                foreach ($this->getCollisionBoxes() as $axis) {
                    foreach($this->getPosition()->getWorld()->getNearbyEntities($axis) as $entity) {
                        if(!($entity instanceof ItemEntity) or !$entity->isAlive() or $entity->isFlaggedForDespawn() or $entity->isClosed()) continue;
                        if(($item = $entity->getItem()) instanceof Item) {
                            if($item->isNull()) {

                                $entity->kill();
                                continue;

                            }

                            $itemClone = (clone $item)->setCount(1);

                            if($tile->getInventory()->canAddItem($itemClone)) {

                                $tile->getInventory()->addItem($itemClone);
                                $item->setCount($item->getCount() - 1);

                                if($item->getCount() <= 0) $entity->flagForDespawn();
                            }
                        }
                    }
                }

                $source = $this->getPosition()->getWorld()->getTile($this->getPosition()->getSide(Facing::DOWN));

                if($source instanceof Container) {

                    $inventory = $source->getInventory();
                    $firstOccupied = null;

                    for($index = 0; $index < $inventory->getSize(); $index++) {
                        if(!$inventory->getItem($index)->isNull()) {

                            $firstOccupied = $index;
                            break;

                        }
                    }

                    if($firstOccupied !== null) {

                        $item = (clone $inventory->getItem($firstOccupied))->setCount(1);

                        if(!$item->isNull()) {
                            if($tile->getInventory()->canAddItem($item)) {

                                $tile->getInventory()->addItem($item);
                                $inventory->removeItem($item);

                            }
                        }
                    }
                }
            }

            if(!($this->getPosition()->getWorld()->getTile($this->getPosition()->getSide(Facing::DOWN)) instanceof HopperTile)) {

                $target = $this->getPosition()->getWorld()->getTile($this->getPosition()->getSide(Facing::DOWN));

                if($target instanceof Container) {

                    $inv = $target->getInventory();

                    foreach($tile->getInventory()->getContents() as $item) {
                        if($item->isNull()) continue;

                        $targetItem = (clone $item)->setCount(1);

                        if($inv instanceof DoubleChestInventory) {

                            $left = $inv->getLeftSide();
                            $right = $inv->getRightSide();

                            if($right->canAddItem($targetItem)) $inv = $right;
                            else $inv = $left;

                        }
                        if($inv->canAddItem($targetItem)) {

                            $inv->addItem($targetItem);
                            $tile->getInventory()->removeItem($targetItem);

                        }
                    }
                }
            }
        }
    }
}