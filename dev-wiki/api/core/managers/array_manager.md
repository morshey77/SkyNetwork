# 💥 ArrayManager

ArrayManager is a class that manages arrays whether player or other object.

## Namespace

```php
use skynetwork\core\managers\ArrayManager;
```

## Constructor

```php
public function __construct()
```

## Properties

```php
/** @var object[] */
protected array $elements = [];
```

## Code

```php
/**
 * @return object[]
 */
public function all(): array
```

```php
/**
 * @param string $key
 * @return object|null
 */
public function get(string $key): ?object
```

```php
/**
 * @param string $key
 * @return bool
 */
public function has(string $key): bool
```

```php
/**
 * @param object $obj
 * @param string $key
 * @return void
 */
public function add(object $obj, string $key): void
```

<pre class="language-php"><code class="lang-php">/**
<strong> * @param string $key
</strong> * @return void
 */
public function remove(string $key): void
</code></pre>
