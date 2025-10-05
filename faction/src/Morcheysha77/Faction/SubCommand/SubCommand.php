<?php


namespace Morcheysha77\Faction\SubCommand;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

class SubCommand
{

    /** @var Main $plugin */
    protected Main $plugin;

    /** @var string[] $alias */
    protected array $alias = [];

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @return string[]
     */
    public function getAlias(): array
    {
        return $this->alias;
    }

    /**
     * @param FPlayer $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(FPlayer $sender, string $commandLabel, array $args): bool
    {
        return true;
    }
}