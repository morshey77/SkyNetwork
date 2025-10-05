<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player\Traits;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\TranslateManager;

trait Lang
{

    /** @var string $lang */
    protected string $lang;

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    /**
     * @param string $message
     * @param array|null $args
     * @return string
     */
    public function translate(string $message, array $args = null): string
    {

        $msg = "";
        $plugin = $this->getServer()->getPluginManager()->getPlugin("Faction");

        if($plugin instanceof Main) {
            if(($manager = $plugin->getManagers("translate")) !== null) {
                if($manager instanceof TranslateManager) {

                    $lang = $manager->getTranslate($this->getLang());
                    $msg = $lang->translates[$message] ?? $lang->translates["error"] . $message;

                    if (is_array($args)) {
                        foreach ($args as $arg) {
                            $msg = preg_replace("/[%]/", $arg, $msg, 1);
                        }
                    }
                }
            }
        }

        return $msg;
    }
}