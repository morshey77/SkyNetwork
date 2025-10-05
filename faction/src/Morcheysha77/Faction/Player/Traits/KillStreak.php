<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player\Traits;


trait KillStreak
{

    /** @var int $killstreak */
    protected int $killstreak;

    /**
     * @return int
     */
    public function getKillStreak(): int
    {
        return $this->killstreak ?? 0;
    }

    /**
     * @param int $killstreak
     */
    public function setKillStreak(int $killstreak): void
    {
        $this->killstreak = $killstreak;
    }

    /**
     * @param int $killstreak
     */
    public function addKillStreak(int $killstreak): void
    {
        $this->killstreak += $killstreak;
    }

    /**
     * @param int $killstreak
     */
    public function removeKillStreak(int $killstreak): void
    {
        $this->killstreak -= $killstreak;
    }
}