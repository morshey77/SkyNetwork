<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\player\GameMode;

use Morcheysha77\Faction\Player\FPlayer;

class StaffManager extends Manager
{

    /** @var array $staff */
    private array $staff = [];

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "staff";
    }

    /**
     * @param string $name
     * @return bool
     */
    public function getStaff(string $name): bool
    {
        return isset($this->staff) AND isset($this->staff[$name]);
    }

    /**
     * @return array
     */
    public function getAllStaff(): array
    {
        return $this->staff;
    }

    /**
     * @param FPlayer $player
     */
    public function setStaff(FPlayer $player): void
    {

        $this->staff[$player->getName()] = $player;

        $player->setGamemode(GameMode::SPECTATOR());
        $player->getServer()->removeOnlinePlayer($player);

    }

    /**
     * @param string $name
     */
    public function removeStaff(string $name): void
    {

        $this->staff[$name]->setGamemode(GameMode::SURVIVAL());
        $this->staff[$name]->getServer()->addOnlinePlayer($this->staff[$name]);

        unset($this->staff[$name]);
        
    }
}