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


trait Coins
{

    /** @var int $coins */
    protected int $coins;

    /**
     * @return int
     */
    public function getCoins(): int
    {
        return $this->coins ?? 0;
    }

    /**
     * @param int $coins
     */
    public function setCoins(int $coins): void
    {

        $this->coins = $coins;
        $this->setCoinsScoreBoard();

    }

    /**
     * @param int $coins
     */
    public function addCoins(int $coins): void
    {

        $this->coins += $coins;
        $this->setCoinsScoreBoard();

    }

    /**
     * @param int $coins
     */
    public function removeCoins(int $coins): void
    {

        $this->coins -= $coins;
        $this->setCoinsScoreBoard();

    }

    public function setCoinsScoreBoard(): void
    {
        $this->setScoreBoard(3, " §9Coins: §f"  . $this->coins);
    }
}