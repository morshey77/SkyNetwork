<?php

namespace skynetwork\core\libs\scoreboard;

use pocketmine\network\mcpe\protocol\{RemoveObjectivePacket,
    SetDisplayObjectivePacket,
    SetScorePacket,
    types\ScorePacketEntry};
use pocketmine\player\Player;

class ScoreboardPacket
{

    /** @var string $displayName */
    protected string $displayName = ' ';

    /** @var array $datas */
    protected array $datas = [];

    /**
     * @param Scoreboard $scoreboard
     */
    public function __construct(protected Scoreboard $scoreboard) {}

    /**
     * @return Scoreboard
     */
    public function getScoreboard(): Scoreboard
    {
        return $this->scoreboard;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $display
     * @return $this
     */
    public function setDisplayName(string $display = ''): self
    {
        if ($display !== $this->getDisplayName()) {

            $this->displayName = $display;
            $this->sendDisplayObjectivePacket();

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

    /**
     * @return void
     */
    public function sendRemoveObjectivePacket(): void
    {
        $this->sendAllDataPacket($this->getScoreboard()->all(), [RemoveObjectivePacket::create($this->scoreboard->getObjectiveName())]);
    }

    /**
     * @return void
     */
    public function sendDisplayObjectivePacket(): void
    {

        $this->sendRemoveObjectivePacket();
        $this->sendAllDataPacket($this->getScoreboard()->all(), [SetDisplayObjectivePacket::create(
            SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR,
            $this->scoreboard->getObjectiveName(),
            $this->displayName,
            'dummy',
            SetDisplayObjectivePacket::SORT_ORDER_ASCENDING
        )]);

    }

    /**
     * @return void
     */
    public function set(): void
    {
        foreach ([SetScorePacket::TYPE_REMOVE, SetScorePacket::TYPE_CHANGE] as $type) {

            $pk = new SetScorePacket;
            $pk->type = $type;
            $pk->entries = array_map(function(string $text, int $score) {

                $entry = new ScorePacketEntry;
                $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
                $entry->objectiveName = $this->scoreboard->getObjectiveName();
                $entry->scoreboardId = $score;
                $entry->score = $score;
                $entry->customName = $text;

                return $entry;

            }, array_values($this->getData()), array_keys($this->getData()));

            $this->sendAllDataPacket($this->getScoreboard()->all(), [$pk]);

        }
    }

    /**
     * @param array $players
     * @param array $packets
     * @return void
     */
    public function sendAllDataPacket(array $players = [], array $packets = []): void
    {
        foreach ($players as $player) {
            if($player instanceof Player) {
                foreach ($packets as $packet) {
                    $player->getNetworkSession()->sendDataPacket($packet);
                }
            }
        }
    }
}