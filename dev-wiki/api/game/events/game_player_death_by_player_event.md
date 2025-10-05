# 🎁 GamePlayerDeathByPlayerEvent

Manager is a class that manages certain elements of server startup and shutdown.

## Namespace

```php
use skynetwork\game\events\GamePlayerDeathByPlayerEvent;
```

## Extends

## Constructor

```php
/**
 * @param \skynetwork\game\managers\game\Game $game
 * @param \pocketmine\player\Player $player
 * @param int $cause
 * @param \pocketmine\player\Player $damager
 */
public function __construct(\skynetwork\game\managers\game\Game $game, \pocketmine\player\Player $player, int $cause, protected \pocketmine\player\Player $damager)
```

## Code

```php
/**
 * @return \pocketmine\player\Player
 */
public function getDamager(): \pocketmine\player\Player
```

```php
/**
 * @return \skynetwork\game\managers\team\Team|null
 */
public function getDamagerTeam(): ?\skynetwork\game\managers\team\Team
```
