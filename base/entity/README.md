# InvLib

```php
/**
* @method static InventoryType CHEST()
* @method static InventoryType DOUBLE_CHEST()
* @method static InventoryType DROPPER()
* @method static InventoryType HOPPER()
*/

/** @var CInventory $inventory create Inventory */
$inventory = new CInventory(InventoryType::CHEST(), $player->getPosition());

/** Manage Inventory */
$inventory->setReadOnly(true | false);

/** Manage Inventory */
$inventory->addItem(instanceof Item);

/** send Inventory to $player */
$player->setCurrentWindow($inventory);
```