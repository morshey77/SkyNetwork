<?php

namespace skynetwork\economy\commands;

use pocketmine\player\Player;
use pocketmine\command\{Command, CommandSender};

use skynetwork\core\managers\ArrayManager;

use skynetwork\economy\{Economy, managers\SessionManager};

class MyEconomy extends Command
{

    public function __construct(protected Economy $plugin, protected string $currency)
    {
        parent::__construct('my' . $currency, 'View your ' . $currency . ' stats', '/my' . $currency);
    }

    /**
     * @inheritDoc
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $manager = $this->plugin->getManager('Session');

            if($manager instanceof SessionManager) {

                $session = $manager->getCurrency($this->currency);

                if($session instanceof ArrayManager)
                    $sender->sendMessage($this->plugin->getTranslate()->getLang($sender->getLanguage()->getLang())->translate('my-economy', [
                        $this->currency, $session->get($sender->getUniqueId()->toString())
                    ]));

            }
        }
    }
}