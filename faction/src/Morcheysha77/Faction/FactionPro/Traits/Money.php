<?php


namespace Morcheysha77\Faction\FactionPro\Traits;


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
    }

    /**
     * @param int $money
     */
    public function addMoney(int $money): void
    {
        $this->money += $money;
    }

    /**
     * @param int $money
     */
    public function removeMoney(int $money): void
    {
        $this->money -= $money;
    }
}