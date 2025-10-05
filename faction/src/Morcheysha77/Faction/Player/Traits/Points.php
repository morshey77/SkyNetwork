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


trait Points
{

    /** @var int $points */
    protected int $points;

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points ?? 0;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    /**
     * @param int $points
     */
    public function addPoints(int $points): void
    {
        $this->points += $points;
    }

    /**
     * @param int $points
     */
    public function removePoints(int $points): void
    {
        $this->points -= $points;
    }
}