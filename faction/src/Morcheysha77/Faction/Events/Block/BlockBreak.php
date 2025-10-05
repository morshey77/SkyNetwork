<?php

namespace Morcheysha77\Faction\Events\Block;


use pocketmine\block\Crops;

use pocketmine\item\Item;
use pocketmine\item\Tool;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\math\Vector3;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\Managers\FactionManager;

class BlockBreak implements Listener
{

    /** @var Main $plugin */
    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function BlockBreakEvent(BlockBreakEvent $event): void
    {

        $player = $event->getPlayer();
        $block = $event->getBlock();
        $item = $event->getItem();
        $level_name = $player->getLevel()->getName();

        if($player instanceof FPlayer AND $player->getGamemode() !== FPlayer::CREATIVE AND !$player->isOp() AND
            (in_array($level_name, ["FFA"])
                OR ($level_name === "Faction" AND
                (($block->getFloorX() <= 423 AND $block->getFloorX() >= 45 AND $block->getFloorZ() <= 468 AND $block->getFloorZ() >= 102)
                    OR ($block->getFloorX() >= 15000 OR $block->getFloorX() <= -15000 OR $block->getFloorZ() >= 15000
                        OR $block->getFloorZ() <= -15000))
                    OR (($manager = $this->plugin->getManagers("faction")) !== null AND $manager instanceof FactionManager
                        AND $manager->interactClaim($player, $block)))
                OR ($level_name === "Minage" AND $player->getFloorX() <= 309 AND $block->getFloorX() >= 234 AND $block->getFloorZ() <= 282 AND $block->getFloorZ() >= 240)
                OR ($block instanceof Crops AND $item instanceof Tool))) $event->setCancelled();
        elseif($item->getId() === Item::GOLD_PICKAXE) {

            $level = $player->getLevel();
            $vector3 = [];

            if($player->getPitch() > 45) $v = [[1, -1], [0, -2], [1, -1]];
            elseif($player->getPitch() < -45) $v = [[1, -1], [2, 0], [1, -1]];
            else $v = [[1, -1], [1, -1], [1, -1]];

            for($x = $v[0][0]; $x >= $v[0][1]; $x--) {
                for($y = $v[1][0]; $y >= $v[1][1]; $y--) {
                    for($z = $v[2][0]; $z >= $v[2][1]; $z--) {
                        if($x !== 0 OR $y !== 0 OR $z !== 0)
                            $vector3[] = new Vector3($block->x + $x, $block->y + $y, $block->z + $z);
                    }
                }
            }

            $item = Item::get(Item::DIAMOND_PICKAXE);

            foreach ($vector3 as $vec3) {
                $level->useBreakOn($vec3, $item, $player);
            }

        } elseif(in_array($level_name, ["Faction", "Minage"])) {

            $drops = $event->getDrops();

            foreach ($drops as $key => $item) {
                if($player->getInventory()->canAddItem($item)) {

                    $player->getInventory()->addItem($item);
                    unset($drops[$key]);

                }
            }

            $player->addXp($event->getXpDropAmount());
            $event->setDrops($drops);
            $event->setXpDropAmount(0);

        }
    }
}