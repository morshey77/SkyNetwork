# 🕋 Database

Database is a class that aims to facilitate the various mysql requests.

## Namespace

```php
use skynetwork\core\libs\mysql\Database;
```

## Constructor

```php
/**
 * @param string|null $hostname
 * @param string|null $username
 * @param string|null $password
 * @param string|null $database
 * @param int|null $port
 * @param string|null $socket
 */
public function __construct(
    protected ?string $hostname = null, protected ?string $username = null,
    protected ?string $password = null, protected ?string $database = null,
    protected ?int $port = null, protected ?string $socket = null
)
```

## Code

<pre class="language-php"><code class="lang-php"><strong>/**
</strong> * @param \pocketmine\Server $server
 * @param string $query
 * @return bool
 */
public function insert(\pocketmine\Server $server, string $query): bool
</code></pre>

```php
/**
 * @param \pocketmine\Server $server
 * @param string $query
 * @return array|bool|null
 */
public function fetch(\pocketmine\Server $server, string $query): array|bool|null
```

```php
/**
 * @param \pocketmine\Server $server
 * @param string $query
 * @return array
 */
public function fetchAll(\pocketmine\Server $server, string $query): array
```
