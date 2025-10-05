# 👨💼 Manager

Manager is a class that manages certain elements of server startup and shutdown.

## Namespace

```php
use skynetwork\core\managers\Manager;
```

## Extends

```php
extends \pocketmine\scheduler\AsyncTask;
```

## Constructor

```php
/**
 * @param \pocketmine\plugin\PluginBase $plugin
 */
public function __construct(protected \pocketmine\plugin\PluginBase $plugin)
```

## Code

```php
/**
 * @return string
 */
abstract public function getName(): string;
```

```php
public function init(): void
```

```php
public function disable(): void {}
```
