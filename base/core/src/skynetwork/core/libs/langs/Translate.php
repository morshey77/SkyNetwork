<?php

namespace skynetwork\core\libs\langs;

use pocketmine\utils\Config;

class Translate
{

    /** @var array $langs */
    protected array $langs = [];

    /**
     * @param string $dataFolder
     */
    public function __construct(string $dataFolder)
    {
        foreach (array_diff(scandir($dataFolder . 'langs'), array('.', '..', )) as $file) {
            $this->langs[substr($file, 0, -5)] = new Lang(new Config($dataFolder . 'langs/' . $file, Config::JSON));
        }
    }

    /**
     * @param string $key
     * @return Lang|null
     */
    public function getLang(string $key): ?Lang
    {
        return $this->langs[$key] ?? ($this->langs[array_keys($this->langs)[0]] ?? null);
    }
}