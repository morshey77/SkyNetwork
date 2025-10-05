# 🔁 RepeatingTask

RepeatingTask is a class that aims to create a repeating task every n seconds.

## Namespace

```php
use skynetwork\core\tasks\RepeatingTask;
```

## Extends

```php
extends \pocketmine\scheduler\Task;
```

## Constructor

```php
public function __construct()
```

## Code

```php
/**
 * The time in seconds between each call of the task
 * @return int
 */
abstract public function getEverySecond(): int;
```

```php
/**
 * @return void
 */
public function onRun(): void
```
