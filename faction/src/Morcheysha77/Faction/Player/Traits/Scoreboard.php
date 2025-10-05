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

use Morcheysha77\Faction\Player\Packet\ScoreBoard as ScorePacket;

trait Scoreboard
{

    /** @var ScorePacket $scoreboard */
    protected ScorePacket $scoreboard;

    /**
     * @return ScorePacket|null $scoreboard
     */
    public function getScoreBoard(): ?ScorePacket
    {
        return $this->scoreboard ?? null;
    }

    /**
     * @param int $line
     * @param string $name
     */
    public function setScoreBoard(int $line, string $name): void
    {
        $this->getScoreBoard()?->setLine($line, $name)->set();
    }

    public function removeScoreBoard(): void
    {
        if($this->getScoreBoard() !== null) {

            $this->getScoreBoard()->sendRemoveObjectivePacket();
            unset($this->scoreboard);

        }
    }

    protected function addScoreBoard(): void
    {
        $this->scoreboard = (new ScorePacket($this))->setDisplayName(self::SCOREBOARD)
            ->setLine(0, "   " . self::BAR . self::BAR)
            ->setLine(1, " §9Rank: §f" . $this->getRank())
            ->setLine(2, " §9Money: §f"  . $this->getMoney())
            ->setLine(3, " §9Coins: §f"  . $this->getCoins())
            ->setLine(4, " §9Online: §f" . count($this->getServer()->getOnlinePlayers()))
            ->setLine(5, "§r   " . self::BAR . self::BAR);

        $this->getScoreBoard()->set();
    }
}