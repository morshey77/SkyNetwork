<?php


namespace Morcheysha77\Faction\Tiles\Interfaces;


interface SeeInterface
{

    public const TAG_TARGET = "target";
    public const ACTION =
        [
            "open" => 0,
            "close" => 1,
            "connect" => 2,
            "interact" => 3,
            "interact_player" => 4,
            "interact_target" => 5
        ];

    public const ARMOR_INVENTORY =
        [
            0 => 47,
            1 => 48,
            2 => 50,
            3 => 51
        ];
}