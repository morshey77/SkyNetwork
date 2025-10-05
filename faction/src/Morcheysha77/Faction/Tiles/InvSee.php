<?php


namespace Morcheysha77\Faction\Tiles;


use pocketmine\block\{VanillaBlocks, utils\DyeColor};
use pocketmine\item\Item;

use pocketmine\math\Vector3;
use pocketmine\world\World;

use pocketmine\inventory\{ArmorInventory, PlayerInventory, transaction\action\SlotChangeAction};
use pocketmine\nbt\tag\{ListTag, CompoundTag};

use Morcheysha77\Faction\Inventories\InvSee as InvSeeInventory;

class InvSee extends SeeTile
{

    /**
     * InvSee constructor.
     * @param World $world
     * @param Vector3 $pos
     */
    public function __construct(World $world, Vector3 $pos)
    {

        parent::__construct($world, $pos);
        $this->inventory = new InvSeeInventory($this);

    }

    /**
     * @return string
     */
    public function getDefaultName(): string
    {
        return "Inv" . parent::getDefaultName();
    }


    /**
     * @param int $action
     * @param SlotChangeAction|null $transaction
     */
    public function synchronize(int $action, SlotChangeAction $transaction = null): void 
    {

        $server = $this->getPosition()->getWorld()->getServer();
        $name = $this->getTarget();
        $player = $server->getPlayerExact($name);
        
        if($name !== null) {
            switch($action) {
                
                case self::ACTION["open"]:
                    
                    $contents = [];
                    
                    if($player !== null) {
                        
                        foreach ($player->getInventory()->getContents() as $slot => $item) {
                            $contents[$slot] = $item;
                        }
                        
                        foreach ($player->getArmorInventory()->getContents() as $slot => $item) {
                            $contents[self::ARMOR_INVENTORY[$slot]] = $item;
                        }
                        
                    } else {
                        
            			foreach($server->getOfflinePlayerData($name)->getListTag("Inventory") as $nbt){

            			    if($nbt instanceof CompoundTag) {

                                $slot = $nbt->getByte("Slot");

                                if($slot >= 100 and $slot < 104)
                                    $contents[self::ARMOR_INVENTORY[$slot - 100]] = Item::nbtDeserialize($nbt);
                                elseif($slot >= 9)
                                    $contents[$slot - 9] = Item::nbtDeserialize($nbt);
                            }
            			}
            		}
                    
                    foreach (
                        [
                            45 => "", 46 => "Helmet ->", 
                            49 => "<- Chestplate | Leggings ->", 52 => "<- Boots", 
                            53 => ""
                        ]
                        as $slot => $name) {

                        $contents[$slot] = VanillaBlocks::STAINED_GLASS()->setColor(DyeColor::WHITE())->asItem()->setCustomName($name);
                        
                    }
                    
                    $this->getInventory()->setContents($contents);
                    
                    break;
                
                case self::ACTION["close"]:
                    
                    if($player === null) {
                        
                        $contents = [];
                        
                		for($slot = 0; $slot < 36; ++$slot) {
                		    
                			$item = $this->getInventory()->getItem($slot);
                			if(!$item->isNull()) 
                			    $contents[] = $item->nbtSerialize($slot + 9);
                			    
                		}
                		for($slot = 100; $slot < 104; ++$slot) {
                		    
                			$item = $this->getInventory()->getItem(self::ARMOR_INVENTORY[$slot - 100]);
                			if(!$item->isNull())
                			    $contents[] = $item->nbtSerialize($slot);
                			    
                		}
                		
                		$nbt = $server->getOfflinePlayerData($name);
                		$nbt->setTag("Inventory", new ListTag($contents));
                		$server->saveOfflinePlayerData($name, $nbt);
                        
                    }
                    
                    break;
                
                case self::ACTION["connect"]:
                    
                    if($player !== null) {
                        
                        $contents = $this->getInventory()->getContents();
		                $player->getInventory()->setContents(array_slice($contents, 0, $player->getInventory()->getSize()));
		                $player->getArmorInventory()->setContents(array_intersect_key($contents, array_flip(self::ARMOR_INVENTORY)));
                        
                    }
                    
                    break;
                    
                case self::ACTION["interact_target"]:
                    
                    if($player !== null) {
                        if($transaction !== null) {
                            
                            $inventory = $transaction->getInventory();
                            $slot = $transaction->getSlot();
                            $item = $transaction->getTargetItem();
                            
                            if($inventory instanceof InvSeeInventory) {
                                if(($armor_slot = array_search($slot, self::ARMOR_INVENTORY, true)) !== false) 
		                                $player->getArmorInventory()->setItem($armor_slot, $item);
                                else
                                    $player->getInventory()->setItem($slot, $item);
                            }
                        }
                    }

                    break;

                case self::ACTION["interact_player"]:

                    if($player !== null) {
                        if($transaction !== null) {

                            $inventory = $transaction->getInventory();
                            $slot = $transaction->getSlot();
                            $item = $transaction->getTargetItem();

                            if($inventory instanceof InvSeeInventory)
                                $this->getInventory()->setItem($slot, $item);
                            else {
                                if($inventory instanceof PlayerInventory)
                                    $this->getInventory()->setItem($slot, $item);
                                elseif($inventory instanceof ArmorInventory)
                                    $this->getInventory()->setItem(self::ARMOR_INVENTORY[$slot], $item);
                            }
                        }
                    }

                    break;

            }
        }
    }
}