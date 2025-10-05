<?php


namespace Morcheysha77\Faction\SubCommand\Faction;


use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\SubCommand\{SubCommand, SubCommandMain};

class SubCommandFaction extends SubCommandMain
{

    public function __construct(Main $plugin)
    {

        parent::__construct($plugin);
        $this->registerSubCommand(dirname(__FILE__) . "/SubCommands");

    }

    /**
     * @param FPlayer $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(FPlayer $sender, string $commandLabel, array $args): bool
    {

        $command = ucfirst(strtolower($args[0]));
        array_shift($args);

        if(($class = $this->matchSubCommand($command, $args)) instanceof SubCommand)
            $class->execute($sender, $commandLabel, $args);
        else
            $sender->sendMessage($sender->translate("Faction_Help"));

        return true;
    }
}