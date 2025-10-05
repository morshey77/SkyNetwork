<?php

namespace skynetwork\economy;

use pocketmine\plugin\PluginBase;

use skynetwork\core\traits\{ManagersTrait, RecursiveRegisterTrait, SaveDirTrait};
use skynetwork\core\libs\langs\Translate;

use ReflectionException;

class Economy extends PluginBase
{

    use ManagersTrait, RecursiveRegisterTrait, SaveDirTrait;

    protected Translate $translate;

    protected function onLoad(): void
    {

        $this->saveDefaultConfig();
        $this->saveDir('langs');

        $this->translate = new Translate($this->getDataFolder());

    }

    /**
     * @throws ReflectionException
     */
    protected function onEnable(): void
    {

        $dirname = str_replace(str_replace('\\', '/', __NAMESPACE__), '', dirname(__FILE__));

        $this->register($dirname,__DIR__ . '/managers', 'Manager');
        $this->register($dirname,__DIR__ . '/listeners', 'Listener');

    }

    /**
     * @return Translate
     */
    public function getTranslate(): Translate
    {
        return $this->translate;
    }
}