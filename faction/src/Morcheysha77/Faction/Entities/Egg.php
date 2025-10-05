<?php

namespace Morcheysha77\Faction\Entities;


use pocketmine\item\Item;

use pocketmine\block\Block;
use pocketmine\block\Bedrock;
use pocketmine\block\InvisibleBedrock;

use pocketmine\entity\projectile\Egg as Eg;

use pocketmine\math\RayTraceResult;

use Morcheysha77\Faction\Player\FPlayer;

class Egg extends Eg
{

    /** @var int $gravity */
    protected $gravity = 0;
    /** @var int $collideTicks */
    protected int $collideTicks = 0;

    public function entityBaseTick(int $tickDiff = 1): bool
    {

        $hasUpdate = parent::entityBaseTick($tickDiff);

        if($this->blockHit === null) {

            $this->collideTicks += $tickDiff;

            if($this->collideTicks > 300) {

                $this->flagForDespawn();
                $hasUpdate = true;

            }
        } else $this->collideTicks = 0;

        return $hasUpdate;
    }

    /**
     * @param Block $blockHit
     * @param RayTraceResult $hitResult
     */
    protected function onHitBlock(Block $blockHit, RayTraceResult $hitResult): void
    {
        if(!($blockHit instanceof Bedrock OR $blockHit instanceof InvisibleBedrock)) {

            $owner = $this->getOwningEntity();

            if($owner instanceof FPlayer) {

                $item = Item::get(Item::DIAMOND_PICKAXE);
                $this->getLevel()->useBreakOn($blockHit, $item, $owner);

            }

            parent::onHitBlock($blockHit, $hitResult);

        }
    }
}