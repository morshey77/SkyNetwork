# 🔭 Scoreboard

Scoreboard is a class that aims to manage a whole group of players who are influenced by the ScoreboardPacket.

## Namespace

```php
use skynetwork\core\libs\scoreboard\Scoreboard;
```

## Extends

{% content-ref url="../../managers/array_manager.md" %}
[array\_manager.md](../../managers/array\_manager.md)
{% endcontent-ref %}

## Constructor

```php
/**
 * @param string $objectiveName
 */
public function __construct(protected string $objectiveName)
```

## Code

```php
/**
 * @return string
 */
public function getObjectiveName(): string
```

```php
/**
 * @return \skynetwork\core\libs\scoreboard\ScoreboardPacket
 */
public function getScoreboardPacket(): \skynetwork\core\libs\scoreboard\ScoreboardPacket
```

```php
/**
 * @param \pocketmine\player\Player $player
 * @return void
 */
public function add(\pocketmine\player\Player $player): void
```
