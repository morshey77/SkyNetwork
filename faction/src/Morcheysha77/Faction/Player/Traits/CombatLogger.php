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


trait CombatLogger
{

    /** @var int $combat_logger */
    protected int $combat_logger;

    /**
     * @return int
     */
    public function getCombatLogger(): int
    {
        return $this->combat_logger ?? 0;
    }

    /**
     * @param int $combat_logger
     */
    public function setCombatLogger(int $combat_logger): void
    {
        $this->combat_logger = $combat_logger;
    }

    /**
     * @return bool
     */
    public function isFight(): bool
    {
        return $this->getCombatLogger() > time();
    }
}