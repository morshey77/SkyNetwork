<?php


namespace Morcheysha77\Faction\Commands\Rank;


use pocketmine\crafting\FurnaceType;

use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Commands\Properties\Command;

class Furnace extends Command
{

    /**
     * Furnace constructor.
     */
    public function __construct()
    {
        parent::__construct("furnace", "You can cook a items!");
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
            if(($recipe = $s->getServer()->getCraftingManager()->getFurnaceRecipeManager(FurnaceType::FURNACE())
                    ->match($s->getInventory()->getItemInHand())) !== null) {

                $s->getInventory()->setItemInHand($recipe->getResult());
                $s->sendMessage($s->translate("furnace_cook"));

            } else $s->sendMessage($s->translate("furnace_not_cook"));
        }

        return true;
    }
}