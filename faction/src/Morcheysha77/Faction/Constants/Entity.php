<?php

namespace Morcheysha77\Faction\Constants;

use pocketmine\data\bedrock\EffectIds;

interface Entity extends Prefix
{

    public const
        TIME = 99999 * 20,
        ARMOR =
        [
            302 => [
                EffectIds::NIGHT_VISION => [
                    "time" => self::TIME,
                    "amplifier" => 0,
                    "visible" => false
                ],
                EffectIds::WATER_BREATHING => [
                    "time" => self::TIME,
                    "amplifier" => 0,
                    "visible" => false
                ]
            ],
            303 => [
                EffectIds::RESISTANCE => [
                    "time" => self::TIME,
                    "amplifier" => 0,
                    "visible" => false
                ]
            ],
            304 => [
                EffectIds::FIRE_RESISTANCE => [
                    "time" => self::TIME,
                    "amplifier" => 0,
                    "visible" => false
                ]
            ],
            305 => [
                EffectIds::SPEED => [
                    "time" => self::TIME,
                    "amplifier" => 0,
                    "visible" => false
                ]
            ]
        ];

}