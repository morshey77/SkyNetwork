<?php


namespace Morcheysha77\Faction\Items;


use pocketmine\Player;
use pocketmine\entity\Entity;

use pocketmine\item\Shears as Sr;
use pocketmine\block\Block;

use pocketmine\math\Vector3;

use Morcheysha77\Faction\Items\Tool\DurableTrait;

class Shears extends Sr
{

    use DurableTrait {
        applyDamage as aDamage;
    }

    /**
     * @return int
     */
    public function getDurability(): int
    {
        return 5;
    }

    /**
     * @return string
     */
    public function getProjectileEntityType(): string
    {
        return "Egg";
    }

    /**
     * @return float
     */
    public function getThrowForce(): float
    {
        return 1.5;
    }

    /**
     * @param Player $player
     * @param Vector3 $directionVector
     * @return bool
     */
    public function onClickAir(Player $player, Vector3 $directionVector): bool
    {

        $nbt = Entity::createBaseNBT($player->add(0, $player->getEyeHeight()), $directionVector, $player->yaw, $player->pitch);
        $nbt->setTag(clone $player->namedtag->getCompoundTag("Skin"));
        $projectile = Entity::createEntity($this->getProjectileEntityType(), $player->getLevelNonNull(), $nbt, $player);

        if($projectile !== null) $projectile->setMotion($projectile->getMotion()->multiply($this->getThrowForce()));

        $projectile->spawnToAll();

        return $this->applyDamage(1);
    }

    /**
     * @param Block $block
     * @return bool
     */
    public function onDestroyBlock(Block $block): bool
    {
        return false;
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function applyDamage(int $amount): bool
    {
        return $this->aDamage(
            intval(round(parent::getMaxDurability() / $this->getMaxDurability())),
            $this->getMaxDurability(), $this->getDurability()
        );
    }
}