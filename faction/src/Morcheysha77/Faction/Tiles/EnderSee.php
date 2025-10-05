<?php


namespace Morcheysha77\Faction\Tiles;


use pocketmine\item\Item;

use pocketmine\math\Vector3;
use pocketmine\world\World;

use pocketmine\inventory\{PlayerEnderInventory, transaction\action\SlotChangeAction};
use pocketmine\nbt\tag\{ListTag, CompoundTag};

use Morcheysha77\Faction\Inventories\EnderSee as EnderSeeInventory;

class EnderSee extends SeeTile
{

    /**
     * EnderSee constructor.
     * @param World $world
     * @param Vector3 $pos
     */
    public function __construct(World $world, Vector3 $pos)
    {

        parent::__construct($world, $pos);
        $this->inventory = new EnderSeeInventory($this);

    }

    /**
     * @return string
     */
    public function getDefaultName(): string
    {
        return "Ender" . parent::getDefaultName();
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
                    
                    if($player !== null)
                        $contents = $player->getEnderInventory()->getContents();
                    else {
                        
            			foreach($server->getOfflinePlayerData($name)->getListTag("EnderChestInventory") as $nbt){
            			    if($nbt instanceof CompoundTag)
            			        $contents[$nbt->getByte("Slot")] = Item::nbtDeserialize($nbt);
            			}
            		}
                    
                    $this->getInventory()->setContents($contents);
                    
                    break;
                
                case self::ACTION["close"]:
                    
                    if($player === null) {
                        
                        $contents = [];
                    
                        foreach($this->getInventory()->getContents() as $slot => $item) {
                            if(!$item->isNull()) $contents[] = $item->nbtSerialize($slot);
                        }

                		$nbt = $server->getOfflinePlayerData($name);
                		$nbt->setTag("EnderChestInventory", new ListTag($contents));
                		$server->saveOfflinePlayerData($name, $nbt);
                        
                    }
                    
                    break;
                
                case self::ACTION["connect"]:
                    
                    if($player !== null)
                        $player->getEnderInventory()->setContents($this->getInventory()->getContents());
                    
                    break;

                case self::ACTION["interact"]:

                    if($player !== null) {
                        if($transaction !== null) {

                            $inventory = $transaction->getInventory();
                            $slot = $transaction->getSlot();
                            $item = $transaction->getTargetItem();

                            if($inventory instanceof EnderSeeInventory)
                                $player->getEnderInventory()->setItem($slot, $item);
                            else
                                $this->getInventory()->setItem($slot, $item);
                        }
                    }

                    break;

                case self::ACTION["interact_target"]:

                    if($player !== null) {
                        if($transaction !== null) {

                            $inventory = $transaction->getInventory();
                            $slot = $transaction->getSlot();
                            $item = $transaction->getTargetItem();

                            if($inventory instanceof EnderSeeInventory)
                                $player->getEnderInventory()->setItem($slot, $item);
                        }
                    }

                    break;

                case self::ACTION["interact_player"]:

                    if($player !== null) {
                        if($transaction !== null) {

                            $inventory = $transaction->getInventory();
                            $slot = $transaction->getSlot();
                            $item = $transaction->getTargetItem();

                            if($inventory instanceof EnderSeeInventory)
                                $this->getInventory()->setItem($slot, $item);
                            elseif($inventory instanceof PlayerEnderInventory)
                                $this->getInventory()->setItem($slot, $item);
                        }
                    }

                    break;
                
            }
        }
    }
}