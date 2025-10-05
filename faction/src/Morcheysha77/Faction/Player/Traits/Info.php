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


use pocketmine\network\mcpe\protocol\types\DeviceOS;
use pocketmine\network\mcpe\protocol\types\InputMode;

use ReflectionClass;

trait Info
{

    /** @var int $device_os_int */
    protected int $device_os_int = -1;
    /** @var int $input_mode_int */
    protected int $input_mode_int = -1;
    /** @var string $model */
    protected string $model = "Unknown";

    /**
     * @param array $info
     */
    public function setInfo(array $info): void
    {

        $this->device_os_int = intval($info[0]);
        $this->input_mode_int = intval($info[1]);
        $this->model = $info[2];

    }

    /**
     * @return string
     */
    public function getDeviceOS(): string
    {
        return array_flip((new ReflectionClass(DeviceOS::class))->getConstants())[$this->getPlayerInfo()->getExtraData()["DeviceOS"]];
    }

    /**
     * @return string
     */
    public function getInputMode(): string
    {
        return array_flip((new ReflectionClass(InputMode::class))->getConstants())[$this->getPlayerInfo()->getExtraData()["CurrentInputMode"]];
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->getPlayerInfo()->getExtraData()["DeviceModel"] !== "" ? $this->getPlayerInfo()->getExtraData()["DeviceModel"] : "Unknown";
    }
}