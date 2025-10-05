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


trait Money
{

    /** @var int $money */
    protected int $money;

    /**
     * @return int
     */
    public function getMoney(): int
    {
        return $this->money ?? 0;
    }

    /**
     * @param int $money
     */
    public function setMoney(int $money): void
    {

        $this->money = $money;
        $this->setMoneyScoreBoard();

    }

    /**
     * @param int $money
     */
    public function addMoney(int $money): void
    {

        $this->money += $money;
        $this->setMoneyScoreBoard();

    }

    /**
     * @param int $money
     */
    public function removeMoney(int $money): void
    {

        $this->money -= $money;
        $this->setMoneyScoreBoard();

    }


    public function setMoneyScoreBoard(): void
    {
        $this->setScoreBoard(2, " §9Money: §f"  . $this->money);
    }
}