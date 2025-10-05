# ☠ BossBarPacket

BossBarPacket is a class that aims to manage the boss bar of an entire group of players.

## Namespace

```php
use skynetwork\core\libs\bossbar\BossBarPacket;
```

## Constructor

```php
/**
 * @param \skynetwork\core\libs\bossbar\BossBar $bossBar
 */
public function __construct(protected \skynetwork\core\libs\bossbar\BossBar $bossBar)
```

## Code

```php
/**
 * @return \skynetwork\core\libs\bossbar\BossBar
 */
public function getBossBar(): \skynetwork\core\libs\bossbar\BossBar
```

```php
/**
 * @return string
 */
public function getTitle(): string
```

```php
/**
 * @param string $title
 * @return $this
 */
public function setTitle(string $title = ''): self
```

```php
/**
 * @return float
 */
public function getProgress(): float
```

```php
/**
 * @param float $progress
 * @return $this
 */
public function setProgress(float $progress): self
```

```php
/**
 * @return int
 */
public function getColor(): int
```

```php
/**
 * @param int $color
 * @return $this
 */
public function setColor(int $color = \pocketmine\network\mcpe\protocol\types\BossBarColor::PURPLE): self
```

```php
/**
 * @param array $players
 * @return void
 */
public function removeBossEventPacket(array $players = []): void
```

```php
/**
 * @param array $players
 * @return void
 */
public function sendBossEventPacket(array $players = []): void
```
