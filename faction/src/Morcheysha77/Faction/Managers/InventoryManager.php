<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\inventory\ArmorInventory;
use pocketmine\inventory\PlayerInventory;

use pocketmine\inventory\transaction\action\SlotChangeAction;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Tiles\SeeInterface;

use Morcheysha77\Faction\Tiles\InvSee;
use Morcheysha77\Faction\Tiles\EnderSee;

class InventoryManager extends Manager implements SeeInterface
{

    /** @var array<string, array<string, InvSee|EnderSee>> $target */
    private array $target = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return "inventory";
    }


    /**
     * @param int $action
     * @param InvSee|EnderSee|PlayerInventory|ArmorInventory|string ...$args
     */
    public function synchronize(int $action, ...$args): void
    {

        switch($action) {

            case self::ACTION["open"]:

                $tile = $args[0];

                if($tile instanceof InvSee OR $tile instanceof EnderSee) {
                    foreach ($tile->getInventory()->getViewers() as $viewer) {
                        if($viewer instanceof FPlayer) {

                            $this->target[$tile->getTarget()][strtolower($viewer->getName())] = $tile;
                            $tile->synchronize($action);

                        }
                    }
                }

                break;

            case self::ACTION["close"]:

                foreach ($this->target as $viewers) {
                    foreach ($viewers as $name => $viewer) {
                        if($name === strtolower($args[0])) $viewer->synchronize($action);
                    }
                }

                break;

            case self::ACTION["connect"]:

                foreach ($this->target as $name => $viewers) {
                    if($name === strtolower($args[0])) {
                        foreach ($viewers as $viewer) {
                            $viewer->synchronize($action);
                        }
                    }
                }

                break;

            case self::ACTION["interact"]:

                if($args[1] instanceof SlotChangeAction) {
                    foreach ($this->target as $name => $viewers) {
                        if($name === strtolower($args[0])) {
                            foreach ($viewers as $viewer) {

                                $array = [];

                                foreach ($viewer->getInventory()->getViewers() as $view) {
                                    $array[$view->getName()] = $view;
                                }

                                if($args[1] instanceof PlayerInventory OR $args[1] instanceof ArmorInventory) {
                                    if(array_search($args[1]->getViewers()[0]->getName(), $array, true))
                                        $viewer->synchronize(self::ACTION["interact_target"], $args[1]);
                                    else
                                        $viewer->synchronize(self::ACTION["interact_player"], $args[1]);
                                }
                            }
                        }
                    }
                }

                break;

        }
    }
}