<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Player;

use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\player\PlayerItemHeldEvent;

use Morcheysha77\Faction\Player\FPlayer;

class PlayerItemHeld implements Listener
{

    /**
     * @param PlayerItemHeldEvent $event
     */
    public function PlayerItemHeldEvent(PlayerItemHeldEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if($player instanceof FPlayer) {

            if($item->getId() === Item::DRAGON_BREATH) {
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::LEVITATION), 214748364, -3, false));
            } else {
                if($player->hasEffect(Effect::LEVITATION)) $player->removeEffect(Effect::LEVITATION);
            }

            if($item->getId() === Item::CLOCK) {
                if(!$player->chestfinder) $player->chestfinder = true;
            } else {
                if($player->chestfinder) $player->chestfinder = false;
            }
        }
    }
}