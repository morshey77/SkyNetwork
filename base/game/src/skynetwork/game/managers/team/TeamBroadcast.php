<?php

namespace skynetwork\game\managers\team;

use pocketmine\player\Player;
use pocketmine\world\sound\Sound;

trait TeamBroadcast
{

    /**
     * Sends a direct chat message to players
     *
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function broadcastMessage(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendMessage($this->getGame()->getTranslate()->getLang($player->getLanguage()->getLang())->translate($message, $args));
    }

    /**
     * Sends a popup message to the players
     *
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function broadcastPopup(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendMessage($this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));
    }

    /**
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function broadcastTip(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendTip($this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));
    }

    /**
     * Adds a title text to the user's screen, with an optional subtitle.
     *
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function broadcastTitle(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendTitle($this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));

    }

    /**
     * Sets the subtitle message, without sending a title.
     *
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function broadcastSubTitle(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendSubTitle($this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));
    }

    /**
     * Adds small text to the user's screen.
     *
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     */
    public function broadcastActionBarMessage(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendActionBarMessage($this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));
    }

    /**
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     */
    public function broadcastJukeboxPopup(string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendJukeboxPopup($this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));
    }

    /**
     * Sends a toast message to the players, or queue to send it if a toast message is already shown.
     *
     * @param string $title
     * @param string $message
     * @param array|null $args
     * @param array $players
     * @return void
     */
    public function broadcastToastNotification(string $title, string $message, array $args = null, array $players = []): void
    {
        foreach((count($players) === 0 ? $this->all() : $players) as $player)
            if($player instanceof Player)
                $player->sendToastNotification($title, $this->getGame()->getTranslate()->getLang($player->getLocale())->translate($message, $args));
    }

	public function broadcastSound(Sound $sound, array $players = []): void
	{
		foreach((count($players) === 0 ? $this->all() : $players) as $player)
			if($player instanceof Player)
				$player->broadcastSound($sound);
	}
}