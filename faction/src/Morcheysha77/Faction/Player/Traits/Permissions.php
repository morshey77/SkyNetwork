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


trait Permissions
{

    /** @var array $permissions */
    protected array $permissions =
        [
            "Player" => [],
            "VIP" =>
                [
                    "pocketmine.command.enderchest",
                    "pocketmine.command.repair"
                ],
            "MVP" => [
                "pocketmine.command.enderchest",
                "pocketmine.command.repair"
            ],
            "MVP+" => [
                "pocketmine.command.enderchest",
                "pocketmine.command.repair"
            ],
            "Helper" => [
                "pocketmine.command.enderchest",
                "pocketmine.command.repair",
                "pocketmine.command.staff",
                "pocketmine.command.mute",
                "pocketmine.command.unmute",
                "pocketmine.command.kick"
            ],
            "Moderator" => [
                "pocketmine.command.enderchest",
                "pocketmine.command.repair",
                "pocketmine.command.staff",
                "pocketmine.command.mute",
                "pocketmine.command.unmute",
                "pocketmine.command.kick",
                "pocketmine.command.ban",
                "pocketmine.command.pardon",
                "pocketmine.command.teleport"
            ],
            "Developer" => [
                "pocketmine.command.enderchest",
                "pocketmine.command.repair",
                "pocketmine.command.staff",
                "pocketmine.command.mute",
                "pocketmine.command.unmute",
                "pocketmine.command.kick",
                "pocketmine.command.ban",
                "pocketmine.command.pardon",
                "pocketmine.command.teleport",
                "pocketmine.command.restart",
                "pocketmine.command.slapperspawn",
                "pocketmine.command.admininfo",
                "pocketmine.command.version",
                "pocketmine.command.rank"
            ],
            "Admin" => [
                "pocketmine.command.enderchest",
                "pocketmine.command.repair",
                "pocketmine.command.staff",
                "pocketmine.command.mute",
                "pocketmine.command.unmute",
                "pocketmine.command.kick",
                "pocketmine.command.ban",
                "pocketmine.command.pardon",
                "pocketmine.command.teleport",
                "pocketmine.command.restart",
                "pocketmine.command.slapperspawn",
                "pocketmine.command.admininfo",
                "pocketmine.command.version",
                "pocketmine.command.rank"
            ],
        ];

    public function setPermissions() : void
    {
        foreach($this->permissions[$this->getRank()] as $permission) {

            $this->addAttachment($this->getServer()->getPluginManager()->getPlugin("Faction"))->setPermission($permission, true);
            $this->addAttachment($this->getServer()->getPluginManager()->getPlugin("Faction"), $permission);

        }
    }

    public function delPermissions() : void
    {
        foreach($this->permissions[$this->getRank()] as $permission) {

            $this->addAttachment($this->getServer()->getPluginManager()->getPlugin("Faction"))->unsetPermission($permission);
            $this->addAttachment($this->getServer()->getPluginManager()->getPlugin("Faction"), $permission);

        }
    }
}