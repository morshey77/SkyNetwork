<?php

namespace Morcheysha77\Faction\Managers;


use pocketmine\player\Player;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\entity\Human;

use pocketmine\event\entity\EntityDeathEvent;

use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\CompoundTag;

use pocketmine\math\Vector3;

class SpawnerManager extends Manager 
{

    public const TAG_STACK_DATA = "StackData";

    /** @var array<string, int> $data */
    private array $data = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return "spawner";
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function isStack(Entity $entity): bool
    {
        return !$entity instanceof Human AND ($entity instanceof Living AND isset($this->data[$entity->getId()]));
    }

    /**
     * @param Living $entity
     * @return int
     */
    public function getStackSize(Living $entity): int 
    {
        return $this->isStack($entity) ? $this->data[$entity->getId()] : 1;
    }

    public function increaseStackSize(Living $entity, int $amount = 1): bool
    {
        if($this->isStack($entity)) {

            $this->data[$entity->getId()] = $this->getStackSize($entity) + $amount;

            return true;
        }
        
        return false;
    }
    
    public function decreaseStackSize(Living $entity, int $amount = 1): bool
    {
        if($this->isStack($entity)) {

            $this->data[$entity->getId()] = $this->getStackSize($entity) - $amount;

            return true;
        }
        
        return false;
    }

    public function createStack(Living $entity, $count = 1): void
    {
        if(!$entity instanceof Human AND $entity instanceof Living) $this->data[$entity->getId()] = $count;
    }

    public function addToStack(Living $stack, Living $entity): bool
    {
        if(!$entity instanceof Human AND $entity instanceof Living) {
            if(is_a($entity, get_class($stack)) AND $stack !== $entity) {
                if($this->increaseStackSize($stack, $this->getStackSize($entity))) {
                    
                    $entity->flagForDespawn();
                    return true;
                    
                }
            }

            return false;
        }

        return true;
    }

    public function removeFromStack(Living $entity, Player $damager): bool
    {
        if(!$entity instanceof Human AND $entity instanceof Living) {
            
            assert($this->isStack($entity));
        
            if($this->decreaseStackSize($entity)) {
                    
                $world = $entity->getWorld();
                $pos = new Vector3($entity->getPosition()->getX(), $entity->getPosition()->getY(), $entity->getPosition()->getZ());

                $ev = new EntityDeathEvent($entity, $entity->getDrops(), $entity->getXpDropAmount());
                $ev->call();

                array_map(function($item) use ($world, $pos, $damager) {
                    $damager->getInventory()->canAddItem($item) ? $damager->getInventory()->addItem($item) : $world->dropItem($pos, $item);
                }, $ev->getDrops());

                $damager->getXpManager()->addXp($ev->getXpDropAmount());
                
                return true;
            }

            return false;
        }

        return true;
    }

    public function recalculateStackName(Living $entity): bool
    {
        if(!$entity instanceof Human AND $entity instanceof Living) {
            
            assert($this->isStack($entity));
            $count = $this->getStackSize($entity);
            
            if($count <= 0) $entity->flagForDespawn();
            else {
                
                $entity->setNameTagVisible();
                $entity->setNameTag("§5" . $count . "§9x§5 " . $entity->getName());
                
            }
        }

        return true;
        
    }

    public function findNearbyStack(Living $entity, $range = 16)
    {
        if(!$entity instanceof Human AND $entity instanceof Living) {
            
            $stack = null;
            $bb = $entity->getBoundingBox()->expandedCopy($range, $range, $range);
            
            if (!($entity->isFlaggedForDespawn() OR $entity->isClosed())) {
                foreach($entity->getWorld()->getCollidingEntities($bb) as $e){
                    if(is_a($e, get_class($entity)) AND $stack !== $entity) {
                        if(is_a($e, get_class($entity)) AND $stack !== $entity AND ($distance = $e->getPosition()->distance($entity->getPosition())) < $range) {
                            if(!$this->isStack($e) AND $this->isStack($stack)) continue;
                            
                            $range = $distance;
                            $stack = $e;
                            
                        }
                    }
                }
                
                return $stack;
            }
        }
        
        return true;
    }

    public function addToClosestStack(Living $entity, $range = 16): bool 
    {
        if(!$entity instanceof Human AND $entity instanceof Living) {
            
            $stack = $this->findNearbyStack($entity, $range);
            
            if($this->isStack($stack)) {
                if($this->addToStack($stack, $entity)) {
                    
                    $this->recalculateStackName($stack);
                    return true;
                    
                }
            } else {
                if ($stack instanceof Living && !$stack instanceof Human) {
                    
                    $this->createStack($stack);
                    $this->addToStack($stack, $entity);
                    $this->recalculateStackName($stack);

                    return true;
                    
                }
            }

            return false;
            
        }

        return true;
    }
}
