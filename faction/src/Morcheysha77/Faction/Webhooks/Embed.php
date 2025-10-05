<?php

namespace Morcheysha77\Faction\Webhooks;

class Embed extends Message
{
    
	/** @var array $data */
	protected array $data = [];

    /**
     * @return array
     */
	public function asArray(): array
	{
		return $this->data;
	}

    /**
     * @param string $name
     * @param string|null $url
     * @param string|null $iconURL
     * @return $this
     */
	public function setAuthor(string $name, string $url = null, string $iconURL = null): self
	{
		if(empty($this->data["author"])) $this->data["author"] = [];
		if($url !== null) $this->data["author"]["url"] = $url;
		if($iconURL !== null) $this->data["author"]["icon_url"] = $iconURL;
        $this->data["author"]["name"] = $name;
        return $this;
	}

    /**
     * @param string $title
     * @return $this
     */
	public function setTitle(string $title): self
	{
		$this->data["title"] = $title;
		return $this;
	}

    /**
     * @param string $description
     * @return $this
     */
	public function setDescription(string $description): self
	{
		$this->data["description"] = $description;
		return $this;
	}

    /**
     * @param int $color
     * @return $this
     */
	public function setColor(int $color): self
	{
		$this->data["color"] = $color;
		return $this;
	}

    /**
     * @param string $name
     * @param string $value
     * @param bool $inline
     * @return $this
     */
	public function addField(string $name, string $value, bool $inline = false): self
	{
		if(empty($this->data["fields"])) $this->data["fields"] = [];
		$this->data["fields"][] = [
			"name" => $name,
			"value" => $value,
			"inline" => $inline,
		];
		return $this;
	}

    /**
     * @param string $url
     * @return $this
     */
	public function setThumbnail(string $url): self
	{
		if(empty($this->data["thumbnail"])) $this->data["thumbnail"] = [];
		$this->data["thumbnail"]["url"] = $url;
		return $this;
	}

    /**
     * @param string $url
     * @return $this
     */
	public function setImage(string $url): self
	{
		if(empty($this->data["image"])) $this->data["image"] = [];
		$this->data["image"]["url"] = $url;
		return $this;
	}

    /**
     * @param string $text
     * @param string|null $iconURL
     * @return $this
     */
	public function setFooter(string $text, string $iconURL = null): self
	{
		if(empty($this->data["footer"])) $this->data["footer"] = [];
		if($iconURL !== null) $this->data["footer"]["icon_url"] = $iconURL;
        $this->data["footer"]["text"] = $text;
        return $this;
	}

    /**
     * @param int $timestamp
     * @return $this
     */
	public function setTimestamp(int $timestamp = 0): self
	{
	    if($timestamp === 0) $timestamp = time();
		$this->data["timestamp"] = date("Y-m-d\TH:i:s.v\Z", $timestamp);
		return $this;
	}
}
