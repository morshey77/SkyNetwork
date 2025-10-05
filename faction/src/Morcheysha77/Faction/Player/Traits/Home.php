<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player\Traits;


use pocketmine\world\Position;

trait Home
{

    /** @var array<string, Position> $homes */
    protected array $homes;

    /**
     * @return array<string, Position>
     */
    public function getHomes(): array
    {
        return $this->homes ?? [];
    }

    /**
     * @return string
     */
    public function getSaveHomes(): string
    {

        $homes = "";

        foreach ($this->getHomes() as $name => $position) {

            $homes .= $name . ":" . $position->getFloorX() . ":" . $position->getFloorY() . ":" . $position->getFloorZ()
                . ":" . $position->getLevel()->getName() . ";";

        }

        return $homes;
    }

    /**
     * @param string $name
     * @return Position|null
     */
    public function getHome(string $name): ?Position
    {
        return $this->homes[$name] ?? null;
    }

    /**
     * @param string $homes
     */
    public function setHomes(string $homes): void
    {
        if($homes !== "") {
            foreach (explode(";", $homes) as $home) {
                if($home !== "") {

                    $info = explode(":", $home);
                    $this->addHome($info[0], new Position(intval($info[1]), intval($info[2]), intval($info[3]),
                    $this->getServer()->getLevelByName($info[4]) ?? $this->getServer()->getDefaultLevel()));

                }
            }
        }
    }

    /**
     * @param string $name
     * @param Position $position
     */
    public function addHome(string $name, Position $position): void
    {
        $this->homes[$name] = $position;
    }

    /**
     * @param string $name
     */
    public function removeHome(string $name): void
    {
        if(isset($this->homes) AND isset($this->homes[$name])) unset($this->homes[$name]);
    }
}