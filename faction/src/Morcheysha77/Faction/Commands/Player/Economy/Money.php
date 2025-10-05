<?php


namespace Morcheysha77\Faction\Commands\Player\Economy;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class Money extends Command
{

    /**
     * Money constructor.
     */
    public function __construct()
    {
        parent::__construct("money", "Allows to show money's player", "money <player>", ["seemoney"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {

        $player = empty($args[0]) ? $sender : $sender->getServer()->getPlayerByPrefix($args[0]);

        if(($player = $this->isPlayerSilent($player)) !== null)
            $sender->sendMessage("§9Money : §f" . $player->getMoney());
        else {
            if($sender instanceof FPlayer) $sender->sendMessage($sender->translate("no_player", [$args[0] ?? $sender->getName()]));
            else $sender->sendMessage($this->notPlayer($args[0] ?? $sender->getName()));
        }

        return true;
    }
}