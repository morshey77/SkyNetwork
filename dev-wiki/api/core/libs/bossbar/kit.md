# ☠ BossBar

BossBar is a class that aims to manage a whole group of players who are influenced by the BossbarPacket.

## Namespace

```php
use skynetwork\core\libs\bossbar\BossBar;
```

## Extends

{% content-ref url="../../managers/array_manager.md" %}
[array\_manager.md](../../managers/array\_manager.md)
{% endcontent-ref %}

## Constructor

```php
public function __construct()
```

## Code

```php
/**
 * @return \skynetwork\core\libs\bossbar\BossBarPacket
 */
public function getBossBarPacket(): \skynetwork\core\libs\bossbar\BossBarPacket
```

```php

/**
 * @param \pocketmine\player\Player $player
 * @return void
 */
public function add(\pocketmine\player\Player $player): void
```
