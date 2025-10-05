# 👜 InventoryType

## Namespace
```php
use skynetwork\game\libs\inventory\InventoryType;
```

## Static Instance
```php
/**
* @method static InventoryType CHEST()
* @method static InventoryType DOUBLE_CHEST()
* @method static InventoryType DROPPER()
* @method static InventoryType HOPPER()
*/

InventoryType::CHEST()
InventoryType::DOUBLE_CHEST()
InventoryType::DROPPER()
InventoryType::HOPPER()
```

## Code

```php
/**
* Get ID of Inventory
*
* @return int
*/
public function getID(): int
```

```php
/**
 * Get with ID if is DOUBLE_CHEST
 * 
 * @return bool
 */
public function isDouble(): bool
```

```php
/**
 * Get WindowType with ID
 * 
 * @return int
 */
public function getWindowType(): int
```

```php
/**
 * Get Size with ID
 * 
 * @return int
 */
public function getSize(): int
```

```php
/**
 * Get Block with ID
 * 
 * @return int
 */
public function getBlockID(): int
```
