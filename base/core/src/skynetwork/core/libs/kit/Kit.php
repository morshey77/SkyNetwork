<?php /** @noinspection PhpUnused */

namespace skynetwork\core\libs\kit;

use pocketmine\inventory\SimpleInventory;
use pocketmine\item\{Armor, Item};
use pocketmine\player\Player;

class Kit
{

    protected const SIZE = ['inventory' => 36, 'armor' => 4];

    protected const SLOT_HEAD = 0;
    protected const SLOT_CHEST = 1;
    protected const SLOT_LEGS = 2;
    protected const SLOT_FEET = 3;

    /** @var SimpleInventory $inventory */
    protected SimpleInventory $inventory;

    /** @var SimpleInventory $armorInventory */
    protected SimpleInventory $armorInventory;

    public function __construct()
    {

        $this->inventory = new SimpleInventory(self::SIZE['inventory']);
        $this->armorInventory = new SimpleInventory(self::SIZE['armor']);

    }

    /**
     * Get Item in Kit by Slot
     *
     * @param int $slot
     * @return Item
     */
    public function get(int $slot): Item
    {
        return $this->inventory->getItem($slot);
    }

    /**
     * Get all Item in Kit
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->inventory->getContents();
    }

    /**
     * Add Multiple Item in Inventory
     *
     * @param Item[] $item
     * @return $this
     */
    public function add(Item ...$item): self
    {
        $this->inventory->addItem(...$item);

        return $this;
    }

    /**
     * Remove Multiple Item in Inventory
     *
     * @param Item[] $item
     * @return $this
     */
    public function remove(Item ...$item): self
    {
        $this->inventory->removeItem(...$item);

        return $this;
    }

    /**
     * Set an Item in specific slot
     *
     * @param int $slot
     * @param Item $item
     * @return $this
     */
    public function set(int $slot, Item $item): self
    {
        $this->inventory->setItem($slot, $item);

        return $this;
    }

    /**
     * Set Contents with multiple Item
     *
     * @param Item[] $item
     * @return $this
     */
    public function all(Item ...$item): self
    {
        $this->inventory->setContents($item);

        return $this;
    }

    /**
     * Get Helmet's Item in Inventory
     *
     * @return Item
     */
    public function getHelmet(): Item
    {
        return $this->armorInventory->getItem(self::SLOT_HEAD);
    }

    /**
     * Get Chestplate's Item in Inventory
     *
     * @return Item
     */
    public function getChestplate(): Item
    {
        return $this->armorInventory->getItem(self::SLOT_CHEST);
    }

    /**
     * Get Leggings Item in Inventory
     *
     * @return Item
     */
    public function getLeggings(): Item
    {
        return $this->armorInventory->getItem(self::SLOT_LEGS);
    }

    /**
     * Get Boots Item in Inventory
     *
     * @return Item
     */
    public function getBoots(): Item
    {
        return $this->armorInventory->getItem(self::SLOT_FEET);
    }

    /**
     * Set Helmet's Item in Inventory
     *
     * @param Armor $helmet
     * @return $this
     */
    public function setHelmet(Armor $helmet): self
    {
        $this->armorInventory->setItem(self::SLOT_HEAD, $helmet);

        return $this;
    }

    /**
     * Set Chestplate's Item in Inventory
     *
     * @param Armor $chestplate
     * @return $this
     */
    public function setChestplate(Armor $chestplate): self
    {
        $this->armorInventory->setItem(self::SLOT_CHEST, $chestplate);

        return $this;
    }

    /**
     * Set Leggings Item in Inventory
     *
     * @param Armor $leggings
     * @return $this
     */
    public function setLeggings(Armor $leggings): self
    {
        $this->armorInventory->setItem(self::SLOT_LEGS, $leggings);

        return $this;
    }

    /**
     * Set Boots Item in Inventory
     *
     * @param Armor $boots
     * @return $this
     */
    public function setBoots(Armor $boots): self
    {
        $this->armorInventory->setItem(self::SLOT_FEET, $boots);

        return $this;
    }

    /**
     * Send Kit's Contents to Player's Inventory
     *
     * @param Player $player
     * @return Kit
     */
    public function kit(Player $player): self
    {

        $player->getInventory()->setContents($this->inventory->getContents());
        $player->getArmorInventory()->setContents($this->armorInventory->getContents());

        return $this;
    }

	/**
	 * Get Kit's Inventory
	 *
	 * @return SimpleInventory
	 */
	public function getInventory(): SimpleInventory
	{
		return $this->inventory;
	}
}