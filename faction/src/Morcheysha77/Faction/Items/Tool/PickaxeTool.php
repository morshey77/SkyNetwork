<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Items\Tool;

use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\entity\Entity;

class PickaxeTool extends TieredTool
{

    public function getBlockToolType(): int
    {
        return BlockToolType::TYPE_PICKAXE;
    }

    public function getBlockToolHarvestLevel(): int
    {
        return $this->tier;
    }

    public function getAttackPoints(): int
    {
        return self::getBaseDamageFromTier($this->tier) - 2;
    }


    public function onDestroyBlock(Block $block): bool
    {
        return $block->getHardness() > 0 && $this->applyDamage(1);
    }

    public function onAttackEntity(Entity $victim): bool
    {
        return $this->applyDamage(2);
    }
}