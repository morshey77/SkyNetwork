# 🎒 CInventory

Inventory is a class that aims to create a fake inventory, in order to have it perceived by 1 or more players and to be able to modify the content of this Inventory

## Namespace
```php
use skynetwork\game\libs\inventory\CInventory;
```

## Constructor

```php
/**
 * @param \voltage\inventory\InventoryType $type
 * @param \pocketmine\world\Position $holder
 * @param string $title
 */
public function __construct(
    protected \voltage\inventory\InventoryType $type, 
    protected \pocketmine\world\Position $holder, 
    protected string $title = ''
)
```

## Code

```php
/**
 * Get InventoryType of Inventory
 * 
 * @return \voltage\inventory\InventoryType
 */
public function getInventoryType(): \voltage\inventory\InventoryType
```

```php
/**
 * Get Position of Inventory
 * 
 * @return \pocketmine\world\Position
 */
public function getHolder(): \pocketmine\world\Position
```

```php
/**
 * Get Title of Inventory
 * 
 * @return string
 */
public function getTitle(): string
```

```php
/**
 * Get Listener when inventory is modified
 * 
 * @return Closure|null
 */
public function getListener(): ?Closure
```

```php
/**
 * Get Listener when inventory is closed
 * 
 * @return Closure|null
 */
public function getCloseListener(): ?Closure
```

```php
/**
 * Set Listener when inventory is modified
 * 
 * @param Closure|null $listener
 * @return $this
 */
public function setListener(?Closure $listener): self
```

```php
/**
 * Set Listener when inventory is closed
 * 
 * @param Closure|null $closeListener
 * @return $this
 */
public function setCloseListener(?Closure $closeListener): self
```
