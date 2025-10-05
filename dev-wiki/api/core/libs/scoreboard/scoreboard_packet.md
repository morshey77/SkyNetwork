# 🔬 ScoreboardPacket

Scoreboard is a class that aims to manage the boss bar of an entire group of players.

## Namespace

```php
use skynetwork\core\libs\scoreboard\ScoreboardPacket;
```

## Constructor

```php
/**
 * @param \skynetwork\core\libs\scoreboard\Scoreboard $bossBar
 */
public function __construct(protected \skynetwork\core\libs\scoreboard\Scoreboard $scoreboard)
```

## Code

```php
/**
 * @return \skynetwork\core\libs\scoreboard\Scoreboard
 */
public function getScoreboard(): \skynetwork\core\libs\scoreboard\Scoreboard
```

```php
/**
 * @return string
 */
public function getDisplayName(): string
```

```php
/**
 * @param string $display
 * @return $this
 */
public function setDisplayName(string $display = ""): self
```

```php
/**
 * @return string[]
 */
public function getData(): array
```

```php
/**
 * @param int $number
 * @param string $customname
 * @return $this
 */
public function setLine(int $number, string $customname): self
```

```php
/**
 * @return void
 */
public function sendRemoveObjectivePacket(): void
```

```php
/**
 * @return void
 */
public function sendDisplayObjectivePacket(): void
```

```php
/**
 * @return void
 */
public function set(): void
```

```php
/**
 * @param array $players
 * @param array $packets
 * @return void
 */
public function sendAllDataPacket(array $players = [], array $packets = []): void
```
