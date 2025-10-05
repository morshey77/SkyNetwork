<?php


namespace Morcheysha77\Faction\Blocks;


use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;

use pocketmine\item\Item;

use pocketmine\block\Block;
use pocketmine\block\MonsterSpawner as MS;

use pocketmine\math\Vector3;

use Morcheysha77\Faction\Items\SpawnEgg;

use Morcheysha77\Faction\Constants\Spawner;
use Morcheysha77\Faction\Tiles\Tile;
use Morcheysha77\Faction\Tiles\Spawner as SpawnerTile;

class MonsterSpawner extends MS implements Spawner
{

    public const TAG_ENTITY_ID = "EntityId";

    /**
     * @param Item $item
     * @param Player|null $player
     * @return bool
     */
    public function onActivate(Item $item, Player $player = null): bool
    {
        if($item->getId() == ItemIds::SPAWN_EGG){
            
            $tile = $this->getPosition()->getWorld()->getTile($this->getPosition()->asVector3());
            
            if(!$tile instanceof SpawnerTile){
            
                $tile = Tile::createTile(Tile::SPAWNER, $this->getLevel(), SpawnerTile::createNBT($this));
                
                if($tile instanceof SpawnerTile) {
                    
                    $tile->setEntityId($item->getMeta());
                    
                    if(!$player->isCreative()) $item->pop();
                    return true;
                    
                }
            } else {
                if($tile->getEntityId() <= 0) {

                    $tile->setEntityId($item->getDamage());
                    if(!$player->isCreative()) $item->pop();

                } else $player->sendMessage("§5Ce spawner contient déjà un oeuf !");

                return true;
            }
        }
        
        return false;
        
    }

    /**
     * @param Item $item
     * @param Block $blockReplace
     * @param Block $blockClicked
     * @param int $face
     * @param Vector3 $clickVector
     * @param Player|null $player
     * @return bool
     */
    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool
    {

        parent::place($item, $blockReplace, $blockClicked, $face, $clickVector, $player);
        $this->onActivate((new SpawnEgg())->setDamage(self::NAME[$item->getCustomName()] ?? self::DEFAULT_ID), $player);

        return true;
    }

    /**
     * @param Item $item
     * @return array
     */
    public function getDrops(Item $item): array 
    {
        
        $tile = $this->getPosition()->getWorld()->getTile($this->getPosition()->asVector3());

        $item = ItemFactory::getInstance()->get(ItemIds::MONSTER_SPAWNER)->setCustomName($tile instanceof SpawnerTile
            AND self::ID[$tile->getEntityId()] ?? self::DEFAULT_NAME);
        $item->getNamedTag()->setInt(self::TAG_ENTITY_ID, $tile->getEntityId());

        return [$item];
    }

    /**
     * @return int
     */
    public function getXpDropAmount(): int
    {
        return 0;
    }

    public function onScheduledUpdate(): void
    {
        parent::onScheduledUpdate();
    }
}