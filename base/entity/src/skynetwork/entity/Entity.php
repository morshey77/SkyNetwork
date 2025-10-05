<?php

namespace skynetwork\entity;

use pocketmine\plugin\PluginBase;

use skynetwork\core\enums\RecursiveRegisterType;
use skynetwork\core\traits\RecursiveRegisterTrait;

use ReflectionException;

class Entity extends PluginBase
{

    use RecursiveRegisterTrait;

    /**
     * @throws ReflectionException
     */
    protected function onEnable(): void
    {
        $this->register(
            str_replace(str_replace('\\', '/', __NAMESPACE__), '', dirname(__FILE__)),
            __DIR__ . '/listeners', RecursiveRegisterType::LISTENER
        );
    }
}