<?php


namespace Morcheysha77\Faction\Items\Tool;

use pocketmine\nbt\tag\StringTag;

trait DurableTrait
{

    /**
     * @param int $amount
     * @param int $base
     * @param int $new
     * @return bool
     */
    public function applyDamage(int $amount, int $base, int $new): bool
    {

        $amount -= $this->getUnbreakingDamageReduction($amount);

        if(!$this->getNamedTag()->hasTag("Durabilité", StringTag::class))
            $this->getNamedTag()->setString("Durabilité", $new - 1);

        $durability = intval($this->getNamedTag()->getString("Durabilité", 0));

        $this->getNamedTag()->setString("Durabilité", $durability - $amount);
        $this->setDamage(
            intval(round($durability / ($new / $base) - $base) * -1)
        );

        if($durability <= 0) {
            if($this->isUnbreakable()) return false;
            elseif($this->isBroken()) $this->onBroken();
        }

        return true;
    }
}