<?php

namespace Morcheysha77\Faction\Tiles;


use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\item\Item;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;

use pocketmine\tile\Spawnable;

use Morcheysha77\Faction\Constants\Spawner as SpawnerConstant;

class Spawner extends Spawnable implements SpawnerConstant
{

    /** @var string */
    public const
        TAG_ENTITY_ID = "EntityId",
        TAG_SPAWN_COUNT = "SpawnCount",
        TAG_SPAWN_RANGE = "SpawnRange",
        TAG_MIN_SPAWN_DELAY = "MinSpawnDelay",
        TAG_MAX_SPAWN_DELAY = "MaxSpawnDelay",
        TAG_DELAY = "Delay";

    /** @var int */
    protected int
        $entityId = 0,
        $spawnCount = 4,
        $spawnRange = 4,
        $minSpawnDelay = 500,
        $maxSpawnDelay = 500,
        $delay;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::DEFAULT_NAME;
    }

    /**
     * @return int
     */
    protected function generateRandomDelay(): int
    {
        return ($this->delay = mt_rand($this->minSpawnDelay, $this->maxSpawnDelay));
    }

    /**
     * @param int $entityId
     */
    public function setEntityId(int $entityId): void
    {

        $this->entityId = $entityId;
        $this->onChanged();
        $this->scheduleUpdate();

    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * @return bool
     */
    public function onUpdate(): bool
    {
        if($this->isClosed()) return false;

        $this->timings->startTiming();

        if($this->canUpdate()) {
            if($this->delay <= 0) {

                $success = false;

                for($i = 0; $i < $this->spawnCount; $i++) {
                    
                    $pos = $this->add(mt_rand() / mt_getrandmax() * $this->spawnRange, mt_rand(-1, 1), mt_rand() / mt_getrandmax() * $this->spawnRange);
                    $target = $this->getLevel()->getBlock($pos);
                    
                    if($target->getId() == Item::AIR){
                        
                        $success = true;
                        $entity = Entity::createEntity(
                            $this->entityId,
                            $this->getLevel(),
                            Entity::createBaseNBT($target->add(0.5, 0, 0.5), null, lcg_value() * 360, 0)
                        );

                        if($entity instanceof Entity) $entity->spawnToAll();
                    }
                }
                if($success) $this->generateRandomDelay();
            } else $this->delay--;
        }

        $this->timings->stopTiming();

        return true;
    }

    /**
     * @return bool
     */
    public function canUpdate(): bool
    {
        if($this->entityId !== 0 && $this->getLevel()->isChunkLoaded($this->getX() >> 4, $this->getZ() >> 4)){
            
            $hasPlayer = false;
            $count = 0;
            
            foreach($this->getLevel()->getEntities() as $e){
                if($e instanceof Player && $e->distance($this) <= 15) 
                    $hasPlayer = true;
                if($e::NETWORK_ID == $this->entityId) $count++;
            }

            return ($hasPlayer && $count < 15);
        }

        return false;
    }

    /**
     * @param CompoundTag $nbt
     */
    public function addAdditionalSpawnData(CompoundTag $nbt): void
    {
        $this->applyBaseNBT($nbt);
    }

    /**
     * @param CompoundTag $nbt
     */
    private function applyBaseNBT(CompoundTag $nbt): void
    {
        foreach (
            [
                self::TAG_ENTITY_ID => $this->entityId,
                self::TAG_SPAWN_COUNT => $this->spawnCount,
                self::TAG_SPAWN_RANGE => $this->spawnRange,
                self::TAG_MIN_SPAWN_DELAY => $this->minSpawnDelay,
                self::TAG_MAX_SPAWN_DELAY => $this->maxSpawnDelay,
                self::TAG_DELAY => $this->delay
            ]
        as $name => $value) {
            $nbt->setInt($name, $value);
        }
    }

    /**
     * @param CompoundTag $nbt
     */
    protected function readSaveData(CompoundTag $nbt): void
    {
        if(empty($this->delay)) $this->generateRandomDelay();
        
        if($nbt->hasTag(self::TAG_SPAWN_COUNT, ShortTag::class) || $nbt->hasTag(self::TAG_ENTITY_ID, StringTag::class)) {
            
            $nbt->removeTag(
                self::TAG_ENTITY_ID, self::TAG_SPAWN_COUNT, self::TAG_SPAWN_RANGE,
                self::TAG_MIN_SPAWN_DELAY, self::TAG_MAX_SPAWN_DELAY, self::TAG_DELAY
            );

        }

        foreach (
            [
                self::TAG_ENTITY_ID => $this->entityId,
                self::TAG_SPAWN_COUNT => $this->spawnCount,
                self::TAG_SPAWN_RANGE => $this->spawnRange,
                self::TAG_MIN_SPAWN_DELAY => $this->minSpawnDelay,
                self::TAG_MAX_SPAWN_DELAY => $this->maxSpawnDelay,
                self::TAG_DELAY => $this->delay
            ]
            as $name => $value) {
            if(!$nbt->hasTag($name, IntTag::class)) $nbt->setInt($name, $value);
        }

        $this->scheduleUpdate();
        
    }

    /**
     * @param CompoundTag $nbt
     */
    protected function writeSaveData(CompoundTag $nbt): void
    {
        $this->applyBaseNBT($nbt);
    }
}