<?php

namespace skynetwork\core\libs\bossbar;

use pocketmine\network\mcpe\protocol\{BossEventPacket, types\BossBarColor};
use pocketmine\player\Player;

class BossBarPacket
{

    /** @var string $title */
    private string $title = ' ';

    /** @var float $health */
    private float $progress = 1.0;

    /** @var int $color */
    private int $color = BossBarColor::PURPLE;

    /**
     * @param BossBar $bossBar
     */
    public function __construct(protected BossBar $bossBar) {}

    /**
     * @return BossBar
     */
    public function getBossBar(): BossBar
    {
        return $this->bossBar;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title = ''): self
    {
        if ($title !== $this->getTitle()) {

            $this->title = $title;
            $this->sendBossEventPacket();

        }

        return $this;
    }

    /**
     * @return float
     */
    public function getProgress(): float
    {
        return $this->progress;
    }

    /**
     * @param float $progress
     * @return $this
     *
     * @noinspection PhpUnused
     */
    public function setProgress(float $progress): self
    {
        if ($progress !== $this->getProgress()) {

            $this->progress = $progress;
            $this->sendBossEventPacket();

        }

        return $this;
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    /**
     * @param int $color
     * @return $this
     *
     * @noinspection PhpUnused
     */
    public function setColor(int $color = BossBarColor::PURPLE): self
    {
        if ($color !== $this->getColor()) {

            $this->color = min($color, BossBarColor::WHITE);
            $this->sendBossEventPacket();

        }

        return $this;
    }

    /**
     * @param array $players
     * @return void
     */
    public function removeBossEventPacket(array $players = []): void
    {
        foreach (($players ?? $this->getBossBar()->all()) as $player)
            if($player instanceof Player)
                $player->getNetworkSession()->sendDataPacket(BossEventPacket::hide($player->getId()));
    }

    /**
     * @param array $players
     * @return void
     */
    public function sendBossEventPacket(array $players = []): void
    {

        $this->removeBossEventPacket();

        foreach (($players ?? $this->getBossBar()->all()) as $player)
            if($player instanceof Player)
                $player->getNetworkSession()->sendDataPacket(BossEventPacket::show($player->getId(), $this->title, $this->progress, 0, $this->color));

    }
}