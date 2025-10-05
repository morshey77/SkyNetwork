<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ / 
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /  
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |   
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player\Packet;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;

use Morcheysha77\Faction\Player\FPlayer;

class ScoreBoard
{

    /** @var FPlayer $player */
    private FPlayer $player;

    /** @var string $displayname */
    private string $displayname;

    /** @var string */
    private string $objectiveName;

    /** @var array $datas */
    private array $datas = [];

    /**
     * ScoreBoard constructor.
     * @param FPlayer $player
     */
    public function __construct(FPlayer $player)
    {

        $this->player = $player;
        $this->objectiveName = "" . $player->getId() . "";
        $this->displayname = " ";

    }

    /**
     * @return FPlayer
     */
    public function getPlayer(): FPlayer
    {
        return $this->player;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayname;
    }

    /**
     * @param string $display
     * @return $this
     */
    public function setDisplayName(string $display = ""): self
    {
        if ($display !== $this->getDisplayName()) {

            $pk = new SetDisplayObjectivePacket;
            $pk->displayName = $display;
            $pk->objectiveName = $this->objectiveName;
            $pk->displaySlot = 'sidebar';
            $pk->criteriaName = 'dummy';
            $pk->sortOrder = 0;

            $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

            $this->displayname = $display;

        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getData(): array
    {
        return $this->datas;
    }

    /**
     * @param int $number
     * @param string $customname
     * @return $this
     */
    public function setLine(int $number, string $customname): self
    {
        if (empty($this->datas[$number]) OR $this->datas[$number] !== $customname) $this->datas[$number] = $customname;

        return $this;
    }

    public function sendRemoveObjectivePacket(): void
    {

        $pk = new RemoveObjectivePacket;
        $pk->objectiveName = $this->objectiveName;

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

    }

    public function set(): void
    {

        $pk = new SetScorePacket;
        $pk->type = SetScorePacket::TYPE_CHANGE;
        $pk->entries = array_map(function(string $text, int $score) {

            $entry = new ScorePacketEntry;
            $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
            $entry->objectiveName = $this->objectiveName;
            $entry->scoreboardId = $score;
            $entry->score = $score;
            $entry->customName = $text . " ";

            return $entry;

        }, array_values($this->getData()), array_keys($this->getData()));

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

    }
}