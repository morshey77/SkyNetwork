<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Items\Armor;

use pocketmine\item\ChainChestplate as CC;
use Morcheysha77\Faction\Items\Tool\DurableTrait;

class ChainChestplate extends CC
{

    use DurableTrait {
        applyDamage as aDamage;
    }

    /**
     * @return int
     */
    public function getDefensePoints(): int
    {
		return 9;
	}

    /**
     * @return int
     */
	public function getDurability() : int
    {
		return 16928;
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