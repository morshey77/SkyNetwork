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

class SwordTool extends TieredTool 
{

    public function getBlockToolType(): int 
    {
        return BlockToolType::TYPE_SWORD;
    }

    public function getAttackPoints(): int 
    {
        return self::getBaseDamageFromTier($this->tier);
    }

    public function getBlockToolHarvestLevel(): int 
    {
        return 1;
    }

    public function getMiningEfficiency(Block $block): float 
    {
        return parent::getMiningEfficiency($block) * 1.5;
    }

    protected function getBaseMiningEfficiency(): float 
    {
        return 10;
    }

    public function onDestroyBlock(Block $block): bool 
    {
        return ($block->getHardness() > 0 and $this->tier <= self::TIER_DIAMOND) AND $this->applyDamage(2);
    }

    public function onAttackEntity(Entity $victim): bool 
    {
        return $this->tier <= self::TIER_DIAMOND AND $this->applyDamage(1);
    }
}