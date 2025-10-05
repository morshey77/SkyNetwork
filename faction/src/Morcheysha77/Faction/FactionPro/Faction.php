<?php


namespace Morcheysha77\Faction\FactionPro;


use Morcheysha77\Faction\FactionPro\Traits\{Allies, Home, Members, Money, Power};

class Faction
{

    use Allies, Home, Members, Money, Power;

    /** @var string $name */
    protected string $name;

    /**
     * Faction constructor.
     * @param string $name
     * @param int $money
     * @param int $power
     * @param array $allies
     * @param array $members
     */
    public function __construct(string $name, int $money = 0, int $power = 0, array $allies = [], array $members = [])
    {

        $this->name = $name;
        $this->money = $money;
        $this->power = $power;

        $this->allies = $allies;
        $this->members = $members;

    }
}