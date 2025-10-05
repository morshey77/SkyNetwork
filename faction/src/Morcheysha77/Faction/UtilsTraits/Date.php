<?php


namespace Morcheysha77\Faction\UtilsTraits;

trait Date
{

    /**
     * @param int $t
     * @return string
     */
    public function format(int $t): string
    {
        return $t === -1 ? "Indefinite" : str_replace(
            [
                "{month}",
                "{day}",
                "{hour}",
                "{minute}",
                "{second}"
            ],
            [
                floor($t / 2592000),
                floor(($t % 2592000) / 86400),
                floor((($t % 2592000) % 86400) / 3600),
                floor(((($t % 2592000) % 86400) % 3600) / 60),
                ceil(((($t % 2592000) % 86400) % 3600) % 60)
            ], "{month} month(s),  {day} day(s), {hour} hour(s), {minute} minute(s), {second} second(s).");

    }

}