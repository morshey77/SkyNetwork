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
use Morcheysha77\Faction\Tasks\TeleportTask;

use Morcheysha77\Faction\Forms\FormAPI\SimpleForm;
use Morcheysha77\Faction\Forms\FormAPI\CustomForm;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;

class Home extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Home constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("home", "You can show your home !", "", ["h"]);
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
        if(($s = $this->isPlayer($sender)) !== null) $this->Menu($s);

        return true;
    }

    public function Menu(FPlayer $player): void
    {

        $form = new SimpleForm(function(FPlayer $player, int $data = null) {
            if($data !== null) {
                switch ($data) {

                    case 0:
                        $this->MenuList($player);
                        break;

                    case 1:
                        $this->MenuHome($player, "create");
                        break;

                    case 2:
                        $this->MenuHome($player, "delete");
                        break;

                }
            }
        });

        $form->setTitle($player->translate("home_title"));

        $form->addButton($player->translate("home_list"));
        $form->addButton($player->translate("home_create"));
        $form->addButton($player->translate("home_delete"));

        $player->sendForm($form);

    }

    public function MenuList(FPlayer $player): void
    {

        $homes = array_keys($player->getHomes());

        $form = new SimpleForm(function(FPlayer $player, int $data = null) use ($homes) {
            if($data !== null) {
                if($data < count($homes) AND ($position = $player->getHome($homes[$data])) !== null)
                    $this->plugin->getScheduler()->scheduleRepeatingTask(
                        new TeleportTask($player, $position, "Home " . $homes[$data]),
                        20);
                elseif($data === count($homes)) $this->Menu($player);
            }
        });

        $form->setTitle($player->translate("home_title"));

        foreach ($homes as $home) {

            $form->addButton("§l§f- §9" . $home . " §f-", SimpleForm::IMAGE_TYPE_PATH, "textures/house");

        }

        $form->addButton($player->translate("home_back"));

        $player->sendForm($form);

    }

    public function MenuHome(FPlayer $player, string $type): void
    {

        $form = new CustomForm(function(FPlayer $player, array $data = null) use ($type) {
            if(isset($data) AND isset($data[0])) {

                switch ($type) {

                    case "create":
                        $player->addHome($data[0], $player->getPosition());
                        break;

                    case "delete":
                        if($player->getHome($data[0]) !== null) $player->removeHome($data[0]);
                        break;

                }

                $player->sendMessage($player->translate("home_menu", [$type, $data[0]]));
            }
        });

        $form->setTitle("§l§9- §f". ucfirst($type) . " §9-");
        $form->addInput("", $player->translate("home_input"));

        $player->sendForm($form);

    }
}