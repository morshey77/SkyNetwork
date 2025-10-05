<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Commands\Player\Economy;


use pocketmine\command\CommandSender;

use pocketmine\item\ItemFactory;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;

use Morcheysha77\Faction\Forms\FormAPI\CustomForm;
use Morcheysha77\Faction\Forms\FormAPI\SimpleForm;

use Morcheysha77\Faction\Commands\Properties\Command;

class Shop extends Command
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Shop constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("shop", "You can open the shop !");
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

    /**
     * @param FPlayer $player
     */
    public function Menu(FPlayer $player): void
    {

        $categories = $this->plugin->getConfig()->get("Categories");

        $form = new SimpleForm(function(FPlayer $player, $data) use ($categories) {

            if($data !== null) $this->Categories($player, $categories[$data]);

        });

        $form->setTitle("§l§9- §fShop §9-");
        foreach ($categories as $categorie) {

            $list = explode(":", $categorie["Name"]);
            $name = "§l§f- §9" . $list[0] . " §f-";

            if (empty($list[1])) $form->addButton($name);
            else {
                if(filter_var($list[1], FILTER_VALIDATE_URL)) $form->addButton($name, SimpleForm::IMAGE_TYPE_URL, $list[1]);
                else $form->addButton($name,  SimpleForm::IMAGE_TYPE_PATH, $list[1]);
            }
        }

        $player->sendForm($form);
    }

    /**
     * @param FPlayer $player
     * @param array $config
     */
    public function Categories(FPlayer $player, array $config): void
    {

        $items = $config["Items"];

        $form = new SimpleForm(function(FPlayer $player, $data) use ($items) {

            if($data !== null) $this->Item($player, $items[$data]);

        });

        $form->setTitle("§l§9- §f" . explode(":", $config["Name"])[0] . " §9-");
        foreach ($items as $item) {

            $list = explode(":", $item["Name"]);
            $name = "§l§f- §9" . ($list[4] !== "DEFAULT" ? $list[4]
                : ItemFactory::getInstance()->get(intval($list[0]), intval($list[1]), intval($list[2]))->getName()) . " §f-";

            if (empty($list[5])) $form->addButton($name);
            else {
                if(filter_var($list[5], FILTER_VALIDATE_URL)) $form->addButton($name, SimpleForm::IMAGE_TYPE_URL, $list[5]);
                else $form->addButton($name,  SimpleForm::IMAGE_TYPE_PATH, $list[5]);
            }
        }

        $player->sendForm($form);
    }

    /**
     * @param FPlayer $player
     * @param array $config
     */
    public function Item(FPlayer $player, array $config): void
    {

        $shop = explode(":", $config["Name"]);

        $form = new CustomForm(function(FPlayer $player, $data) use ($shop) {

            if($data !== null){

                $item = ItemFactory::getInstance()->get(intval($shop[0]), intval($shop[1]), intval($data[2]));
                if(isset($shop[4]) AND $shop[4] !== "DEFAULT") $item->setCustomName($shop[4]);

                if($data[3] === true){
                    if($player->getInventory()->contains($item)) {

                        $player->addMoney($data[2] * $shop[3]);
                        $player->getInventory()->removeItem($item);
                        $player->sendMessage($player->translate("sell_item", [($shop[4] !== "DEFAULT" ? $shop[4] :
                            ItemFactory::getInstance()->get(intval($shop[0]), intval($shop[1]))->getName()), $data[2], $data[2] * $shop[3]]));

                    } else $player->sendMessage($player->translate("no_sell_count_item"));
                } else {
                    if($player->getInventory()->canAddItem($item)) {
                        if($player->getMoney() >= $data[2] * $shop[2]) {

                            $player->removeMoney($data[2] * $shop[2]);
                            $player->getInventory()->addItem($item);
                            $player->sendMessage($player->translate("buy_item", [($shop[4] !== "DEFAULT" ? $shop[4] :
                                ItemFactory::getInstance()->get(intval($shop[0]), intval($shop[1]))->getName()), $data[2], $data[2] * $shop[2]]));

                        } else $player->sendMessage($player->translate("no_money"));
                    } else $player->sendMessage($player->translate("no_room_inventory"));
                }
            }
        });

        $form->setTitle("§l§9- §f" . ($shop[4] !== "DEFAULT" ? $shop[4]
            : ItemFactory::getInstance()->get(intval($shop[0]), intval($shop[1]))->getName()) . " §9-");
        $form->addLabel("Price : " . $shop[2]);
        $form->addLabel("Sell : " . $shop[3]);
        $form->addSlider("Number(s)", 1, 64);
        $form->addToggle("Buy / Sell");

        $player->sendForm($form);
    }
}