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

use pocketmine\item\Tool;
use InvalidArgumentException;

class TieredTool extends Tool
{

    use DurableTrait {
        applyDamage as aDamage;
    }

    public const TIER_WOODEN = 1;
    public const TIER_GOLD = 2;
    public const TIER_STONE = 3;
    public const TIER_IRON = 4;
    public const TIER_DIAMOND = 5;
    public const TIER_OPALITE = 6;
    public const TIER_PLUTONIUM = 7;

    /** @var int $tier */
    protected int $tier;

    public function __construct(int $id, int $meta, string $name, int $tier) 
    {

        parent::__construct($id, $meta, $name);
        $this->tier = $tier;

    }

    public function getMaxDurability(): int
    {
        return self::getBaseDurabilityFromTier($this->getTier());
    }

    public function getDurability(): int
    {
        return self::getDurabilityFromTier($this->getTier());
    }

    public function getTier(): int 
    {
        return $this->tier;
    }

    public static function getDurabilityFromTier(int $tier): int 
    {

        static $levels = 
        [
            self::TIER_GOLD => 1562,
            self::TIER_WOODEN => 60,
            self::TIER_STONE => 132,
            self::TIER_IRON => 251,
            self::TIER_DIAMOND => 1562,
            self::TIER_OPALITE => 2343,
            self::TIER_PLUTONIUM => 3124
        ];

        if(!isset($levels[$tier])) throw new InvalidArgumentException("Unknown tier '$tier'");

        return $levels[$tier];

    }

    public static function getBaseDurabilityFromTier(int $tier): int
    {

        static $levels =
            [
                self::TIER_GOLD => 33,
                self::TIER_WOODEN => 60,
                self::TIER_STONE => 132,
                self::TIER_IRON => 251,
                self::TIER_DIAMOND => 1562,
                self::TIER_OPALITE => 33,
                self::TIER_PLUTONIUM => 60
            ];

        if(!isset($levels[$tier])) throw new InvalidArgumentException("Unknown tier '$tier'");

        return $levels[$tier];

    }

    public static function getBaseDamageFromTier(int $tier): int 
    {

        static $levels = 
        [
            self::TIER_WOODEN => 5,
            self::TIER_GOLD => 5,
            self::TIER_STONE => 6,
            self::TIER_IRON => 7,
            self::TIER_DIAMOND => 8,
            self::TIER_OPALITE => 24,
            self::TIER_PLUTONIUM => 40
        ];

        if(!isset($levels[$tier])) throw new InvalidArgumentException("Unknown tier '$tier'");

        return $levels[$tier];

    }

    public static function getBaseMiningEfficiencyFromTier(int $tier): int 
    {

        static $levels = 
        [
            self::TIER_WOODEN => 2,
            self::TIER_STONE => 4,
            self::TIER_IRON => 6,
            self::TIER_DIAMOND => 8,
            self::TIER_GOLD => 5,
            self::TIER_OPALITE => 14,
            self::TIER_PLUTONIUM => 16
        ];

        if(!isset($levels[$tier])) throw new InvalidArgumentException("Unknown tier '$tier'");

        return $levels[$tier];

    }

    protected function getBaseMiningEfficiency(): float 
    {
        return self::getBaseMiningEfficiencyFromTier($this->tier);
    }

    public function getFuelTime(): int
    {
        return $this->getTier() === self::TIER_WOODEN ? 200: 0;
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function applyDamage(int $amount): bool
    {
        return $this->aDamage($amount, $this->getMaxDurability(), $this->getDurability());
    }
}
