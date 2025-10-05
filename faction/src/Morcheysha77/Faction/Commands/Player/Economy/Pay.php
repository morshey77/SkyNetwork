<?php


namespace Morcheysha77\Faction\Commands\Player\Economy;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class Pay extends Command
{

    /**
     * Pay constructor.
     */
    public function __construct()
    {
        parent::__construct("pay", "Allows to pay player", "pay <player>");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(($s = $this->isPlayer($sender)) !== null) {
            if(empty($args) OR empty($args[0])) $s->sendMessage($this->getUsage());
            else {
    
                $player = $s->getServer()->getPlayerByPrefix($args[0]);
                $money = intval($args[1]);
                
                if($player instanceof FPlayer) {
                    
                    $s->removeMoney($money);
                    $player->addMoney($money);

                    $s->sendMessage($s->translate("paid_to", [$money, $player->getName()]));
                    $player->sendMessage($player->translate("paid_from", [$money, $sender->getName()]));
                    
                } else $s->sendMessage($s->translate("no_player", [$args[0]]));
            }
        }

        return true;
    }
}