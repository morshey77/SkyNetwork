<?php


namespace Morcheysha77\Faction\Blocks;

use pocketmine\block\Anvil as Av;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Anvil extends Av
{

    public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null): bool
    {
        return false;
    }
}