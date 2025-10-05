<?php

namespace skynetwork\core\libs\bossbar;

use skynetwork\core\managers\ArrayManager;
use Exception;
use pocketmine\player\Player;

class BossBar extends ArrayManager
{

    /** @var BossBarPacket $bossBarPacket */
    protected BossBarPacket $bossBarPacket;


    /**
     * @noinspection PhpPureAttributeCanBeAddedInspection
     */
    public function __construct()
    {
        $this->bossBarPacket = new BossBarPacket($this);
    }


    /**
     * @return BossBarPacket
     */
    public function getBossBarPacket(): BossBarPacket
    {
        return $this->bossBarPacket;
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
            throw new Exception('BossBar::add() - BossBar can only add Player objects!');

        parent::add($obj, $obj->getUniqueId()->toString());
    }
}