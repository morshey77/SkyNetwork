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


trait Messages
{

    /** @var array<string, string> $messages */
    protected array $messages =
        [
            "Player" => "",
            "VIP" => "",
            "MVP" => "",
            "MVP+" => "",
            "Helper" => "",
            "Moderator" => "",
            "Developer" => "",
            "Admin" => "",
        ];

    /**
     * @param array|null $args
     * @return string
     */
    public function getMessageFormat(array $args = null): string
    {

        $msg = $this->messages[$this->getRank()];

        if (is_array($args)) {
            foreach ($args as $arg) {
                $msg = preg_replace("/[%]/", $arg, $msg, 1);
            }
        }

        return $msg;
    }
}