<?php


namespace Morcheysha77\Faction\Managers;


use Morcheysha77\Faction\Main;

class Manager
{

    /** @var Main $plugin */
    protected Main $plugin;

    /**
     * Manager constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        
        $this->plugin = $plugin;
        $this->init();
        
    }

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "";
    }

    public function init(): void {}

    public function disable(): void {}
}