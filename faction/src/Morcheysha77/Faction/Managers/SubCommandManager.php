<?php


namespace Morcheysha77\Faction\Managers;


use Morcheysha77\Faction\SubCommand\SubCommandMain;

class SubCommandManager extends Manager
{

    /** @var array<string, SubCommandMain> */
    private array $subcommands = [];

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "subcommand";
    }

    public function getSubCommand(string $name): ?SubCommandMain
    {
        return $this->subcommands[$name] ?? null;
    }

    public function addSubCommand(string $name, SubCommandMain $class): void
    {
        $this->subcommands[$name] = $class;
    }
}