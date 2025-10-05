<?php

namespace Morcheysha77\Faction\Items;

use pocketmine\Player;
use pocketmine\item\SpawnEgg as SE;
use pocketmine\block\Block;
use pocketmine\math\Vector3;

class SpawnEgg extends SE
{

    public function onActivate(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector): bool
    {
        return false;
    }
}
