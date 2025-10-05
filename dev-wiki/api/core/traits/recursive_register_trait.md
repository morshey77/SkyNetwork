# 🧷 RecursiveRegisterTrait

RecursiveRegisterTrait is a trait that aims to register an entire folder depending on the type to be registered.

## Namespace

```php
use skynetwork\core\traits\RecursiveRegisterTrait;
```

## Trait

```php
use RecursiveRegisterTrait;
```

## Code

```php
/**
 * @param string $dirname
 * @param string $dir
 * @param \skynetwork\core\enums\RecursiveRegisterType $type 
 * @param array|string[] $banned
 */
public function register(string $dirname, string $dir, \skynetwork\core\enums\RecursiveRegisterType $type, array $banned = [".", ".."]): void
```
