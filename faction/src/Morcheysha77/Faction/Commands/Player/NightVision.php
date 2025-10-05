<?php


namespace Morcheysha77\Faction\Commands\Player;


use pocketmine\command\CommandSender;

use pocketmine\data\bedrock\EffectIdMap;
use pocketmine\data\bedrock\EffectIds;

use pocketmine\entity\effect\EffectInstance;

use Morcheysha77\Faction\Commands\Properties\Command;

class NightVision extends Command
{

    /**
     * NightVision constructor.
     */
    public function __construct()
    {
        parent::__construct("nightvision", "You can better see with this effect !", null, ["nv"]);
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
            if($s->getEffects()->has(EffectIdMap::getInstance()->fromId(EffectIds::NIGHT_VISION))) {

                $s->getEffects()->remove(EffectIdMap::getInstance()->fromId(EffectIds::NIGHT_VISION));
                $s->sendMessage($s->translate("night-vision_disable"));

            } else {

                $s->getEffects()->add(new EffectInstance(EffectIdMap::getInstance()->fromId(EffectIds::NIGHT_VISION),
                    20 * 60 * 60 * 60, 0, false));
                $s->sendMessage($s->translate("night-vision_enable"));

            }
        }

        return true;
    }
}