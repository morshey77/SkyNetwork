<?php


namespace Morcheysha77\Faction\FactionPro\Traits;


trait Power
{

    /** @var int $power */
    protected int $power;

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power ?? 0;
    }

    /**
     * @param int $power
     */
    public function setPower(int $power): void
    {
        $this->power = $power;
    }

    /**
     * @param int $power
     */
    public function addPower(int $power): void
    {
        $this->power += $power;
    }

    /**
     * @param int $power
     */
    public function removePower(int $power): void
    {
        $this->power -= $power;
    }
}