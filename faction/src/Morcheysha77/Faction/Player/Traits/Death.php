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


trait Death
{

    /** @var int $death */
    protected int $death;

    /**
     * @return int
     */
    public function getDeath(): int
    {
        return $this->death ?? 0;
    }

    /**
     * @param int $death
     */
    public function setDeath(int $death): void
    {
        $this->death = $death;
    }

    /**
     * @param int $death
     */
    public function addDeath(int $death): void
    {
        $this->death += $death;
    }

    /**
     * @param int $death
     */
    public function removeDeath(int $death): void
    {
        $this->death -= $death;
    }
}