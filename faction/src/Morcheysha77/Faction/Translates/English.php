<?php


namespace Morcheysha77\Faction\Translates;


use Morcheysha77\Faction\Constants\Prefix;

class English implements Prefix
{

    /** @var array<string, string> $translates */
    public array $translates =
        [
            "no_player" => self::COMMAND . "The player §f% §9doesn't exist",
            "offline_player" => self::COMMAND . "This player is offline",
            "paid_to" => self::COMMAND . "You have paid §f% §9to §f%",
            "paid_from" => self::COMMAND . "You was paid §f% §9from §f%",
            "no_room_inventory" => self::COMMAND . "You have no room in your inventory",
            "no_sell_count_item" => self::COMMAND . "You don't have the number of items you want to sell in your inventory",
            "no_money" => self::COMMAND . "You don't have enough money",
            "teleported_to" => self::COMMAND . "You have teleported to §f%",
            "teleported_on"  => self::COMMAND . "You have teleported on §f%",
            "teleported" => self::COMMAND . "You have teleported §f%",
            "teleport_cancelled" => self::COMMAND . "The teleportation was canceled because you moved...",
            "home_menu" => self::COMMAND . "You have % §f%",
            "buy_item" => self::COMMAND . "You bought well §f% §9% for §f%",
            "sell_item" => self::COMMAND . "You sold well §f% §9% for §f%",
            "already_request" => self::COMMAND . "This player already have a request",
            "no_request" => self::COMMAND . "This player doesn't have a request",
            "ask_request" => self::COMMAND . "§f% §9ask teleport to you \n/tpaccept for accept or /tpdeny for deny",
            "send_request" => self::COMMAND . "You sent a request to §f%",
            "tpa_accept_request" => self::COMMAND . "§f% §9have accept your request",
            "tpahere_accept_request" => self::COMMAND . "§f% §9will be teleported to you",
            "deny_request" => self::COMMAND . "§f% §9deny your request",
            "have_deny_request" => self::COMMAND . "You have been deny §f%§9's request",
            "home_title" => "§l§9- §fHomes §9-",
            "home_list" => "§l§f- §9List §f-",
            "home_create" => "§l§f- §9Create §f-",
            "home_delete" => "§l§f- §9Delete §f-",
            "home_back" => "§l§f- §cBack §f-",
            "home_input" => "§l§f- §9name §f-",
            "lang_title" => "§l§9- §fLang §9-",
            "lang_update" => self::COMMAND . "You have update your lang to §f%",
            "night-vision_disable" => self::COMMAND . "You have activated the night vision effect",
            "night-vision_enable" => self::COMMAND . "You have disabled the night vision effect",
            "world_tp_coord" => self::COMMAND . "You have teleported to the coordinates:  (§f%§9, §f%§9, §f%§9)",
            "world_not_exist" => self::COMMAND . "The World §f%§9doesn't exist !",
            "world_exception" => self::COMMAND . "The world encountered an error[§f%§9]: §f%",
            "not_voted" => self::COMMAND . "You haven't voted yet go to the site : \n§fhttps://minecraftpocket-servers.com/server/112687/vote/",
            "vote_reclaim" => self::COMMAND . "You recovered §f% §9Coins !",
            "vote_already_reclaim"  => self::COMMAND . "You have already collected your reward !",
            "furnace_cook" => self::COMMAND . "You cooked this item",
            "furnace_not_cook" => self::COMMAND . "You cannot cook this item",
            "repair_all" => self::COMMAND . "You just repaired all your inventory",
            "repair_hand" => self::COMMAND . "You just repaired the item from your hand",
            "staff_on" => self::COMMAND . "You have activated the staff mod !",
            "staff_off" => self::COMMAND . "You have deactivated the staff mod !",
            "rank_not_exist" => self::COMMAND . "The Rank §f% §9doesn't exist"
        ];

}