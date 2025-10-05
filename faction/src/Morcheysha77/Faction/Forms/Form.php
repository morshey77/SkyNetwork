<?php

declare(strict_types = 1);

namespace Morcheysha77\Faction\Forms;

use pocketmine\form\Form as IForm;
use pocketmine\player\Player;

abstract class Form implements IForm
{

    /** @var array $data */
    protected array $data = [];
    /** @var callable $callable */
    private $callable;

    /**
     * @param callable|null $callable $callable
     */
    public function __construct(?callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @return callable|null
     */
    public function getCallable(): ?callable
    {
        return $this->callable;
    }

    /**
     * @param callable|null $callable
     */
    public function setCallable(?callable $callable): void
    {
        $this->callable = $callable;
    }

    /**
     * @param Player $player
     * @param mixed $data
     */
    public function handleResponse(Player $player, $data): void
    {

        $this->processData($data);
        $callable = $this->getCallable();

        if($callable !== null) $callable($player, $data);
    }

    /**
     * @param $data
     */
    public function processData(&$data): void {}

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
