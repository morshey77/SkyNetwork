<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Staff;


use pocketmine\command\CommandSender;

use pocketmine\entity\Location;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class Teleport extends Command
{

    /**
     * Teleport constructor.
     */
    public function __construct()
    {

        parent::__construct("teleport", "You can tp request to other player !",
            "/teleport <player>|<player> <player>|<x> <y> <z> : <yaw> <pitch>", ["tp"]);
        $this->setPermission("pocketmine.command.teleport");

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if($this->testPermission($sender)) {
            switch(count($args)) {

                case 1:
                case 3:
                case 5:
                    if(!$this->isPlayer($sender)) return false;

                    $subject = $sender;
                    $targetArgs = $args;
                    break;

                case 2:
                case 4:
                    $subject = $this->findPlayer($sender, $args[0]);

                    if(empty($subject)) return false;

                    $targetArgs = $args;
                    array_shift($targetArgs);
                    break;

                default:
                    $sender->sendMessage($this->getUsage());
                    return false;

            }

            switch(count($targetArgs)) {

                case 1:
                    $targetPlayer = $this->findPlayer($sender, $targetArgs[0]);

                    switch(count($targetPlayer)) {

                        case 1:
                            $player = $targetPlayer[0];

                            if(is_array($subject)) $subject = $subject[0];
                            if(($s = $this->isPlayerSilent($subject)) !== null AND ($p = $this->isPlayerSilent($player)) !== null AND $subject->getName() !== $player->getName()) {

                                $s->teleport($p->getPosition());
                                $s->sendMessage($s->translate("teleported_on", [$player->getName()]));

                            }
                            break;

                        default:
                            if(($s = $this->isPlayerSilent($subject)) !== null) {
                                foreach ($targetPlayer as $player) {

                                    if(is_array($s)) $s = $subject[0];
                                    if(($p = $this->isPlayerSilent($player)) !== null AND $s->getName() !== $player->getName())
                                        $p->teleport($s);
                                }

                                $s->sendMessage($s->translate("teleported", [$targetArgs[0]]));

                            }
                            break;
                    }
                    break;

                case 3:
                case 5:
                    if(count($targetArgs) === 5) {

                        $yaw = floatval($targetArgs[3]);
                        $pitch = floatval($targetArgs[4]);

                    } else {

                        $yaw = $subject->yaw;
                        $pitch = $subject->pitch;

                    }

                    if(($s = $this->isPlayerSilent($subject)) !== null) {

                        $s->teleport(new Location(
                            intval($targetArgs[0]), intval($targetArgs[1]), intval($targetArgs[2]), $s->getWorld(), $yaw, $pitch
                        ));
                        $s->translate("world_tp_coord", [intval($targetArgs[0]), intval($targetArgs[1]), intval($targetArgs[2])]);

                    }
                    break;

                default:
                    $sender->sendMessage($this->getUsage());
            }
        }

        return true;
    }

    /**
     * @param CommandSender $sender
     * @param string $arg
     * @return array<FPlayer>
     */
    private function findPlayer(CommandSender $sender, string $arg): array
    {

        $server = $sender->getServer();
        $online = $server->getOnlinePlayers();

        $target = match (strtolower($arg)) {
            "@r" => [$online[array_rand($online)]],
            "@a" => $online,
            default => [$server->getPlayerByPrefix($arg)],
        };

        if(empty($target)) $sender->sendMessage($this->notPlayer($arg));

        return $target;
    }
}