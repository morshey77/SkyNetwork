<?php

namespace skynetwork\core\libs\langs;

use pocketmine\utils\Config;

class Lang
{

    /**
     * @param Config $lang
     */
    public function __construct(protected Config $lang) {}

    /**
     * @param string $message
     * @param array|null $args
     * @return string
     */
    public function translate(string $message, array $args = null): string
    {

        $msg = $this->lang->get($message, '');

        if($msg === '') {

            $msg = $this->lang->get('error', '');
            $args = [$message];

        }

        if (is_array($args)) {
            foreach ($args as $arg) {
                $msg = preg_replace('/%/', $arg, $msg, 1);
            }
        }

        return $this->formatedColor($msg);
    }

    /**
     * @param string $message
     * @return string
     */
    private function formatedColor(string $message): string
    {
        return preg_replace('/&/', '§', $message);
    }
}