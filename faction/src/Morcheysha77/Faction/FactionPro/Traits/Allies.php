<?php


namespace Morcheysha77\Faction\FactionPro\Traits;


trait Allies
{

    /** @var array<string> $allies */
    protected array $allies;

    /**
     * @return array<string>
     */
    public function getAllies(): array
    {
        return $this->allies ?? [];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isAlly(string $name): bool
    {
        return in_array($name, $this->allies);
    }

    public function addAlly(string $name): void
    {
        $this->allies[] = $name;
    }

    public function removeAlly(string $name): void
    {
        unset($this->allies[$name]);
    }
}