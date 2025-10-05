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


trait Rank
{

    /** @var string $rank */
    protected string $rank;

    /**
     * @return string
     */
    public function getRank(): string
    {
        return $this->rank ?? "No Rank";
    }

    /**
     * @param string $rank
     */
    public function setRank(string $rank): void
    {

        $this->rank = $rank;
        $this->setScoreBoard(1, " §9Rank: §f" . $rank);

    }

    /**
     * @param string $rank
     * @return bool
     */
    public function existRank(string $rank): bool
    {
        return array_key_exists($rank, $this->permissions);
    }
}