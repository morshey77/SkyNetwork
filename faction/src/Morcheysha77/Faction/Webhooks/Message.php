<?php

namespace Morcheysha77\Faction\Webhooks;

use JsonSerializable;

class Message implements JsonSerializable 
{
    
	/** @var array $data */
	protected array $data = [];

    /**
     * @param string $content
     * @return $this
     */
	public function setContent(string $content): self
	{
		$this->data["content"] = $content;
		return $this;
	}

    /**
     * @return string|null
     */
	public function getContent(): ?string
	{
		return $this->data["content"];
	}

    /**
     * @return string|null
     */
	public function getUsername(): ?string
	{
		return $this->data["username"];
	}

    /**
     * @param string $username
     * @return $this
     */
	public function setUsername(string $username): self
	{
		$this->data["username"] = $username;
		return $this;
	}

    /**
     * @return string|null
     */
	public function getAvatarURL(): ?string
	{
		return $this->data["avatar_url"];
	}

    /**
     * @param string $avatarURL
     * @return $this
     */
	public function setAvatarURL(string $avatarURL): self
	{
		$this->data["avatar_url"] = $avatarURL;
		return $this;
	}

    /**
     * @param Embed $embed
     * @return $this
     */
	public function addEmbed(Embed $embed): self
	{
		if(is_array($arr = $embed->asArray())) $this->data["embeds"][] = $arr;
		return $this;
	}

    /**
     * @param bool $ttsEnabled
     * @return $this
     */
	public function setTextToSpeech(bool $ttsEnabled): self
	{
		$this->data["tts"] = $ttsEnabled;
		return $this;
	}

    /**
     * @return array
     */
	public function jsonSerialize(): array
    {
		return $this->data;
	}
}
