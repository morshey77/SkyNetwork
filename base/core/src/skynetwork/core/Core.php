<?php

namespace skynetwork\core;

use skynetwork\core\traits\{ManagersTrait};
use skynetwork\core\traits\RecursiveRegisterTrait;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Core extends PluginBase
{

    use SingletonTrait, ManagersTrait, RecursiveRegisterTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }
}