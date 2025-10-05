<?php


namespace Morcheysha77\Faction\Tasks\Every;

use pocketmine\Server;

use pocketmine\scheduler\Task;

use pocketmine\world\World;
use pocketmine\world\particle\RedstoneParticle;

use pocketmine\math\Vector3;

use Morcheysha77\Faction\Player\FPlayer;

class SeeChunkTask extends Task
{

    /**
     * @return int
     */
    public function getEverySecond(): int 
    {
        return 2;
    }

    public function onRun(): void
    {
        foreach(Server::getInstance()->getOnlinePlayers() as $player) {
            if($player instanceof FPlayer) {
                if($player->isOnline() AND $player->seechunk) {

                    $world = $player->getWorld();

                    if($world instanceof World) {

                        $radius = floatval(1 << 4);
                        $xMin = floatval($player->getPosition()->getFloorX() << 4);
                        $zMin = floatval($player->getPosition()->getFloorZ() << 4);
                        $xMax = $xMin + $radius;
                        $zMax = $zMin + $radius;

                        for($x = $xMin; $x <= $xMax; $x += 0.5) {
                            for($z = $zMin; $z <= $zMax; $z += 0.5) {
                                if($x === $xMin OR $x === $xMax OR $z === $zMin OR $z === $zMax)
                                    $world->addParticle(new Vector3($x, $player->getPosition()->getY() + 1.5, $z), new RedstoneParticle(), [$player]);
                            }
                        }
                    }
                }
            }
        }
    }
}