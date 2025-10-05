<?php

namespace skynetwork\hikabrain;

use pocketmine\plugin\PluginBase;

use Exception;

use skynetwork\game\{Core, managers\team\Team};
use skynetwork\hikabrain\game\HikabrainGame;

class Main extends PluginBase
{

    /**
     * @return void
     * @throws Exception
     */
    protected function onLoad(): void
    {
        $this->saveDefaultConfig();
        $this->saveResource('arenas/arena1.json');
        $this->saveResource('langs/en.json');
        $this->saveResource('langs/fra.json');
        $this->saveResource('maps/map.zip');

        Core::getInstance()->setCreateGame(function(): HikabrainGame {

            $arenas = $this->getConfig()->get('arenas');
            $teams = [];

            for ($i = 0; $i < intval($this->getConfig()->get('team_size')); $i++)
                $teams[] = new Team(intval($this->getConfig()->get('team_player_minsize')), $this->getConfig()->get('team_player_maxsize'), $i);

            return new HikabrainGame($this->getServer()->getWorldManager(), $this->getDataFolder(), $arenas[array_rand($arenas)], $teams);
        });
    }
}