<?php


namespace Morcheysha77\Faction\FactionPro\Traits;


trait Members
{

    /** @var array<string> $members */
    protected array $members;

    /**
     * @return array<string>
     */
    public function getMembers(): array
    {
        return $this->members ?? [];
    }

    public function addMember(string $name): void
    {
        $this->members[] = $name;
    }

    public function removeMember(string $name): void
    {
        unset($this->members[$name]);
    }
}