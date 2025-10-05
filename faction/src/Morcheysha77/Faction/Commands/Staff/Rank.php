<?php


namespace Morcheysha77\Faction\Commands\Staff;


use pocketmine\Server;

use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Tasks\QueryAsync;

use Morcheysha77\Faction\Commands\Properties\Command;
use Morcheysha77\Faction\Constants\Webhook as WebhookConstant;

use Morcheysha77\Faction\Webhooks\Webhook;
use Morcheysha77\Faction\Webhooks\Message;
use Morcheysha77\Faction\Webhooks\Embed;

class Rank extends Command implements WebhookConstant
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Rank constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("rank", "Allows to rank up a player", "rank <player> <rank>");
        $this->setPermission("pocketmine.command.rank");
        $this->plugin = $plugin;

    }


    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if($this->testPermission($sender)) {
            if(empty($args) OR empty($args[0]) OR empty($args[1])) $sender->sendMessage($this->getUsage());
            else {

                $server = $this->plugin->getServer();
                $staff = $sender->getName();
                $players = [];

                foreach(scandir($server->getDataPath() . "players/") as $file) {
                    $players[] = rtrim($file, ".dat");
                }

                if($this->isPlayerSilent($player = $server->getPlayerByPrefix($args[0])) !== null OR in_array(strtolower($args[0]), $players)) {
                    if(($s = $this->isPlayerSilent($sender)) !== null AND !$s->existRank($args[1]))
                        $s->sendMessage($s->translate("rank_not_exist", [$args[1]]));
                    else {
                        if(($p = $this->isPlayerSilent($player)) !== null) {

                            $rank = $p->getRank();

                            $p->delPermissions();
                            $p->setRank($args[1]);
                            $p->setPermissions();

                            $this->sendMessage($server, $p->getName(), $p->getRank(), $rank, $staff);

                        } else {

                            $server->getAsyncPool()->submitTask(new QueryAsync(
                                "Network",
                                "SELECT * FROM player WHERE player = '" . strtolower($args[0]) . "';",
                                function(QueryAsync $self, Server $server) use ($staff, $args) {

                                    $result = $self->getResult();

                                    if(is_array($result)) {

                                        $server->getAsyncPool()->submitTask(new QueryAsync(
                                            "Network",
                                            "REPLACE INTO player(`player`, `rank`, `lang`, `coins`, `ip`, `port`) VALUES ('"
                                            . strtolower($args[0]) . "','" . $args[1] . "','" . $result["lang"] . "','"
                                            . $result["coins"] . "','" . $result["ip"] . "','" . $result["port"] . "');",
                                            function(){}
                                        ));
                                        $this->sendMessage($server, $args[0], $args[1], strval($result["rank"]), $staff);

                                    }
                                    else {

                                        $server->getAsyncPool()->submitTask(new QueryAsync(
                                            "Network",
                                            "REPLACE INTO player(`player`, `rank`, `lang`, `coins`, `ip`, `port`) VALUES ('"
                                            . strtolower($args[0]) . "','" . $args[1] . "','" . "English" . "','"
                                            . 0 . "','" . "0.0.0.0" . "','" . 1000 . "');",
                                            function(){}
                                        ));
                                        $this->sendMessage($server, $args[0], $args[1], "Player", $staff);

                                    }
                                }
                            ));
                        }
                    }
                } else $sender->sendMessage($this->notPlayer($args[0]));
            }
        }

        return true;
    }

    private function sendMessage(Server $server, string $name, string $rank, string $last_rank, string $staff): void
    {

        $server->broadcastMessage(self::COMMAND . "§f" . $name . " §9has been rank to §f" . $rank . "\n§9Staff : §f" . $staff);
        (new Webhook(self::URL["network"]))
            ->send(
                (new Message())
                    ->addEmbed(
                        (new Embed())
                            ->setDescription("**Rank**\nPlayer : **" . $name . "**\nRank : **" . $last_rank . "** -> **"
                                . $rank ."**\nStaff : **" . $staff . "**\nFrom : **" . $server->getConfigGroup()->getConfigString("name") . "**")
                            ->setColor(intval(str_replace("#", "", "#d98afd"), 16))
                            ->setFooter("AntiCheat • 1.0.0")
                            ->setTimestamp()
                    )
            );

    }
}