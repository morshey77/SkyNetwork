<?php


namespace Morcheysha77\Faction\Entities;

use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use Morcheysha77\Faction\Player\FPlayer;
use pocketmine\world\World;
use pocketmine\nbt\tag\CompoundTag;

class NPC extends Human
{

    /** @var string $callable */
    protected string $callable;

    public function __construct(Level $level, CompoundTag $nbt, string $callable)
    {

        parent::__construct($level, $nbt);
        $this->callable = base64_decode($callable);

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "NPC";
    }

    /**
     * @param EntityDamageEvent $source
     */
    public function attack(EntityDamageEvent $source): void
    {
        if($source instanceof EntityDamageByEntityEvent) {

            $damager = $source->getDamager();

            if($damager instanceof FPlayer) {
                if($damager->isOp() AND $damager->getGamemode() === FPlayer::CREATIVE)
                    $this->flagForDespawn();
                else eval($this->callable);
            }
        }
    }
}