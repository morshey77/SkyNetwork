<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Player;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Managers\TranslateManager;

use Morcheysha77\Faction\Forms\FormAPI\SimpleForm;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class Lang extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Lang constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("lang", "You can switch your language !", "", ["language"]);
        $this->plugin = $plugin;

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(($s = $this->isPlayer($sender)) !== null) {
            if(($manager = $this->plugin->getManagers("translate")) !== null AND $manager instanceof TranslateManager) {

                $languages = array_keys($manager->getAllTranslate());

                $form = new SimpleForm(function(FPlayer $s, int $data = null) use ($languages) {
                    if($data !== null AND $data < count($languages)) {

                        $s->setLang($languages[$data]);
                        $s->sendMessage($s->translate("lang_update", [$languages[$data]]));

                    }
                });

                $form->setTitle($s->translate("lang_title"));

                foreach ($languages as $lang) {

                    $form->addButton("§l§f- §9" . $lang . " §f-", SimpleForm::IMAGE_TYPE_PATH,
                        "textures/languages/" . $lang);

                }

                $s->sendForm($form);

            }
        }

        return true;
    }
}