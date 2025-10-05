# 🇲🇫 Translate

Translate is a class that aims to manage the langs.

## Namespace

```php
use skynetwork\core\libs\langs\Translate;
```

## Constructor

```php
/**
 * @param string $dataFolder
 */
public function __construct(string $dataFolder)
```

## Code

```php
/**
 * @param string $key
 * @return \skynetwork\core\libs\langs\Lang|null
 */
public function getLang(string $key): ?\skynetwork\core\libs\langs\Lang
```
