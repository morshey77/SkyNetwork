<?php

namespace skynetwork\economy\managers;

use pocketmine\player\Player;

use skynetwork\core\managers\{ArrayManager, Manager};
use skynetwork\core\libs\mysql\Database;

class SessionManager extends Manager
{

    /** @var array<string, ArrayManager> $currencies */
    protected array $currencies = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Session';
    }

    /**
     * @return void
     */
    public function init(): void
    {

        $mysql = $this->plugin->getConfig()->get('mysql');
        $database = new Database($mysql['host'], $mysql['username'], $mysql['password'], $mysql['database']);

        foreach ($this->plugin->getConfig()->get('currencies') as $currency) {

            $database->insert($this->plugin->getServer(), 'CREATE TABLE IF NOT EXISTS ' . $currency . ' (uuid VARCHAR(16), balance INT)');
            $this->currencies[$currency] = new ArrayManager();

        }

        $database->close();
    }

    /**
     * @param Player $player
     * @return void
     */
    public function onPlayerJoin(Player $player): void
    {
            $mysql = $this->plugin->getConfig()->get('mysql');
            $database = new Database($mysql['host'], $mysql['username'], $mysql['password'], $mysql['database']);

            foreach ($this->currencies as $currency => $manager) {


                $result = $database->fetch($this->plugin->getServer(), 'SELECT * FROM ' . $currency . ' WHERE username = ''
                    . $player->getUniqueId()->toString() . '''
                );
                $manager->add((is_array($result) AND isset($result['balance'])) ? $result['balance'] : 0, $player->getUniqueId()->toString());

            }

            $database->close();
    }

    /**
     * @param Player $player
     * @return void
     */
    public function onPlayerQuit(Player $player): void
    {
        $mysql = $this->plugin->getConfig()->get('mysql');
        $database = new Database($mysql['host'], $mysql['username'], $mysql['password'], $mysql['database']);

        foreach ($this->currencies as $currency => $manager) {

            $database->insert($this->plugin->getServer(), 'REPLACE INTO ' . $currency . ' (username, balance) VALUES (''
                . $player->getUniqueId()->toString() . '', ' . $manager->get($player->getUniqueId()->toString()) . ')'
            );
            $manager->remove($player->getUniqueId()->toString());

        }

        $database->close();
    }

    /**
     * @param $currency
     * @return ArrayManager|null
     */
    public function getCurrency($currency): ?ArrayManager
    {
        return $this->currencies[$currency] ?? null;
    }
}