# ⚔ Kit

Kit is a class that aims to save your items, and to be able to assign them with a method to a player or modify the contents of this kit with other methods

## Namespace

```php
use skynetwork\core\libs\kit\Kit;
```

## Constructor

```php
public function __construct()
```

## Code

```php
/**
 * Get Item in Kit by Slot
 *
 * @param int $slot
 * @return \pocketmine\item\Item
 */
public function get(int $slot): \pocketmine\item\Item
```

```php
/**
 * Add Multiple Item in inventory
 * 
 * @param \pocketmine\item\Item[] $item
 * @return $this
 */
public function add(\pocketmine\item\Item ...$item): self
```

```php
/**
 * Remove Multiple Item in inventory
 * 
 * @param \pocketmine\item\Item[] $item
 * @return $this
 */
public function remove(\pocketmine\item\Item ...$item): self
```

```php
/**
 * Set an Item in specific slot
 * 
 * @param int $slot
 * @param \pocketmine\item\Item $item
 * @return $this
 */
public function set(int $slot, \pocketmine\item\Item $item): self
```

```php
/**
 * Set Contents with multiple Item
 * 
 * @param \pocketmine\item\Item[] $item
 * @return $this
 */
public function all(\pocketmine\item\Item ...$item): self
```

```php
/**
 * Get Helmet's Item in Inventory
 * 
 * @return \pocketmine\item\Item
 */
public function getHelmet(): \pocketmine\item\Item
```

```php
/**
 * Get Chestplate's Item in Inventory
 * 
 * @return \pocketmine\item\Item
 */
public function getChestplate(): \pocketmine\item\Item
```

```php
/**
 * Get Leggings Item in Inventory
 * 
 * @return \pocketmine\item\Item
 */
public function getLeggings(): \pocketmine\item\Item
```

```php
/**
 * Get Boots Item in Inventory
 * 
 * @return \pocketmine\item\Item
 */
public function getBoots(): \pocketmine\item\Item
```

```php
/**
 * Set Helmet's Item in Inventory
 * 
 * @param \pocketmine\item\Armor $helmet
 * @return $this
 */
public function setHelmet(\pocketmine\item\Armor $helmet): self
```

```php
/**
 * Set Chestplate's Item in Inventory
 * 
 * @param \pocketmine\item\Armor $chestplate
 * @return $this
 */
public function setChestplate(\pocketmine\item\Armor $chestplate): self
```

```php
/**
 * Set Leggings Item in Inventory
 * 
 * @param \pocketmine\item\Armor $leggings
 * @return $this
 */
public function setLeggings(\pocketmine\item\Armor $leggings): self
```

```php
/**
 * Set Boots Item in Inventory
 * 
 * @param \pocketmine\item\Armor $boots
 * @return $this
 */
public function setBoots(\pocketmine\item\Armor $boots): self
```

```php
/**
 * Send Kit's Contents to Player's Inventory
 * 
 * @param \pocketmine\player\Player $player
 * @return $this
 */
public function kit(\pocketmine\player\Player $player): self
```

```php
/**
 * Get Kit's Inventory
 *
 * @return SimpleInventory
 */
public function getInventory(): SimpleInventory
```
