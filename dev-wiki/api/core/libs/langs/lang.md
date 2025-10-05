# 🇬🇧 Lang

Lang is a class that aims to translate message in the lang.

## Namespace

```php
use skynetwork\core\libs\langs\Lang;
```

## Constructor

```php
/**
 * @param \pocketmine\utils\Config $lang
 */
public function __construct(protected \pocketmine\utils\Config $lang)
```

## Code

```php
/**
 * @param string $message
 * @param array|null $args
 * @return string
 */
public function translate(string $message, array $args = null): string
```

```php
/**
 * @param string $message
 * @return string
 */
private function formatedColor(string $message): string
```
