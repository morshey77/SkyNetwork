<?php


namespace Morcheysha77\Faction\Tasks\Every;


use pocketmine\Server;

use pocketmine\block\tile\Chest;

use pocketmine\scheduler\Task;

use pocketmine\world\World;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Tiles\Hopper as HopperTile;

class ChestFinderTask extends Task
{

    /**
     * @return int
     */
    public function getEverySecond(): int 
    {
        return 10;
    }

    public function onRun(): void
    {
        foreach(Server::getInstance()->getOnlinePlayers() as $player) {
            if($player instanceof FPlayer) {
                if($player->isOnline() AND $player->chestfinder) {

                    $count = 0;
                    $radius = 25;
                    $xMax = $player->getPosition()->getX() + $radius;
                    $zMax = $player->getPosition()->getZ() + $radius;

                    for($x = $player->getPosition()->getX() - $radius; $x <= $xMax; $x += 16) {
                        for($z = $player->getPosition()->getZ() - $radius; $z <= $zMax; $z += 16) {

                            $world = $player->getWorld();

                            if($world instanceof World) {

                                $chunk = $player->getWorld()->getChunk($x >> 4, $z >> 4);
                                if(!$player->getWorld()->isChunkLoaded($x >> 4, $z >> 4))
                                    $player->getWorld()->loadChunk($x >> 4, $z >> 4);

                                foreach($chunk->getTiles() as $tile) {
                                    if($tile instanceof Chest OR $tile instanceof HopperTile) $count++;
                                }
                            }
                        }
                    }

                    $player->sendPopup("§1" . $count . " §5coffres au alentours");

                }
            }
        }
    }
}