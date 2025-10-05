<?php


namespace skynetwork\core\managers;

use pocketmine\plugin\PluginBase;

abstract class Manager
{

    /**
     * Manager constructor.
     * @param PluginBase $plugin
     */
    public function __construct(protected PluginBase $plugin)
    {
        $this->init();
    }

    /**
     * @return string
     */
    abstract public function getName(): string;

    public function init(): void {}

    public function disable(): void {}
}