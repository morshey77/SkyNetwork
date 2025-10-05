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


trait Kill
{

    /** @var int $kill */
    protected int $kill;

    /**
     * @return int
     */
    public function getKill(): int
    {
        return $this->kill ?? 0;
    }

    /**
     * @param int $kill
     */
    public function setKill(int $kill): void
    {
        $this->kill = $kill;
    }

    /**
     * @param int $kill
     */
    public function addKill(int $kill): void
    {
        $this->kill += $kill;
    }

    /**
     * @param int $kill
     */
    public function removeKill(int $kill): void
    {
        $this->kill -= $kill;
    }
}