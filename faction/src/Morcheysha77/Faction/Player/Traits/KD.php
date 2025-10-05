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


trait KD
{

    /**
     * @return float
     */
    public function getKD(): float
    {

        $kill = $this->getKill();
        $death = $this->getDeath();

        return $kill > 0 AND $death > 0 ? ($kill / $death) : ($kill > 0 ? $kill : ($death > 0 ? $death * -1 : 0));
    }
}