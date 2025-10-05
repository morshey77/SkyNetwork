<?php


namespace Morcheysha77\Faction\Translates;


use Morcheysha77\Faction\Constants\Prefix;

class Francais implements Prefix
{

    /** @var array<string, string> $translates */
    public array $translates =
        [
            "no_player" => self::COMMAND . "Le joueur §f% §9n'existe pas",
            "offline_player" => self::COMMAND . "Ce joueur est hors ligne",
            "paid_to" => self::COMMAND . "Tu as payé §f% §9à §f%",
            "paid_from" => self::COMMAND . "Tu as été payé §f% §9par §f%",
            "no_room_inventory" => self::COMMAND . "Vous n'avez pas de place dans votre inventaire",
            "no_sell_count_item" => self::COMMAND . "Vous n'avez pas le nombre d'articles que vous souhaitez vendre dans votre inventaire",
            "no_money" => self::COMMAND . "Vous n'avez pas assez d'argent",
            "teleported_to" => self::COMMAND . "Vous vous êtes téléporté au §f%",
            "teleport_cancelled" => self::COMMAND . "La téléportation a était annuler car vous avez bougez...",
            "home_menu" => self::COMMAND . "Tu as % §f%",
            "buy_item" => self::COMMAND . "Tu as bien acheté §f% §9% pour §f%",
            "sell_item" => self::COMMAND . "Tu as bien vendu §f% §9% pour §f%",
            "already_request" => self::COMMAND . "Ce joueur a déjà une demande",
            "no_request" => self::COMMAND . "Ce joueur n'a pas de demande",
            "ask_request" => self::COMMAND . "§f% §9vous demande de vous téléporter \n/tpaccept pour accepter ou /tpdeny pour refuser",
            "send_request" => self::COMMAND . "Vous avez envoyé une demande à §f%",
            "tpa_accept_request" => self::COMMAND . "§f% §9as accepté ta demande",
            "tpahere_accept_request" => self::COMMAND . "§f% §9sera téléporté vers vous",
            "deny_request" => self::COMMAND . "§f% §9refuse votre demande",
            "have_deny_request" => self::COMMAND . "Vous avez refusé la demande de §f%",
            "home_title" => "§l§9- §fHomes §9-",
            "home_list" => "§l§f- §9Liste §f-",
            "home_create" => "§l§f- §9Créer §f-",
            "home_delete" => "§l§f- §9Supprimer §f-",
            "home_back" => "§l§f- §cRetour §f-",
            "home_input" => "§l§f- §9nom §f-"
        ];

}