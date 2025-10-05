<?php


namespace Morcheysha77\Faction\FactionPro\Traits;


trait Home
{

    /** @var array<int|string> $home */
    protected array $home;

    /**
     * @return array<string>
     */
    public function getHome(): array
    {
        return $this->home ?? [0, 90, 0, "Faction"];
    }

    /**
     * @return bool
     */
    public function existHome(): bool
    {
        return isset($this->home);
    }

    public function setHome(string $x, string $y, string $z, string $level): void
    {
        $this->home = [intval($x), intval($y), intval($z), $level];
    }

    public function removeHome(): void
    {
        unset($this->home);
    }
}