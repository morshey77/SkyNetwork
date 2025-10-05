<?php

namespace skynetwork\core\libs\scoreboard;

use skynetwork\core\managers\ArrayManager;
use Exception;
use pocketmine\player\Player;

class Scoreboard extends ArrayManager
{

    /** @var ScoreboardPacket $scoreboardPacket */
    protected ScoreboardPacket $scoreboardPacket;

    /**
     * @param string $objectiveName
     *
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct(protected string $objectiveName)
    {
        $this->scoreboardPacket = new ScoreboardPacket($this);
    }

    /**
     * @return string
     */
    public function getObjectiveName(): string
    {
        return $this->objectiveName;
    }

    /**
     * @return ScoreboardPacket
     *
     * @noinspection PhpUnused
     */
    public function getScoreboardPacket(): ScoreboardPacket
    {
        return $this->scoreboardPacket;
    }

    /**
     * @param object $obj
     * @param string $key
     * @return void
     * @throws Exception
     */
    public function add(object $obj, string $key = ''): void
    {
        if (!$obj instanceof Player)
            throw new Exception('Scoreboard::add() - Scoreboard can only add Player objects!');

        parent::add($obj, $obj->getUniqueId()->toString());
    }
}