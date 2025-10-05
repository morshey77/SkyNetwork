<?php


namespace Morcheysha77\Faction\Commands\Staff\Sanction\Ban;


use pocketmine\server;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Main;

use Morcheysha77\Faction\Constants\Webhook as WebhookConstant;

use Morcheysha77\Faction\Webhooks\Webhook;
use Morcheysha77\Faction\Webhooks\Message;
use Morcheysha77\Faction\Webhooks\Embed;

use Morcheysha77\Faction\Tasks\QueryAsync;


class Pardon extends Command implements WebhookConstant
{

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Pardon constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("pardon", "Allows to pardon a player", "unban <player>", ["unban"]);
        $this->setPermission("pocketmine.command.pardon");
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
            if(empty($args) OR empty($args[0])) $sender->sendMessage($this->getUsage());
            else {

                $name = $args[0];

                $this->plugin->getServer()->getAsyncPool()->submitTask(new QueryAsync(
                    "Faction",
                    "SELECT * FROM ban WHERE player = '" . strtolower($name) . "';",
                    function(QueryAsync $self, Server $server) use ($sender, $name) {
                        if($self->getResult() !== null) {

                            $info = $self->getResult();

                            if(is_array($info)) {

                                $server->getAsyncPool()->submitTask(new QueryAsync(
                                    "Faction",
                                    "DELETE FROM ban WHERE player = '" . strtolower($name) . "';",
                                    function(){}
                                ));
                                $sender->sendMessage(self::PREFIX . "§f" . $name . " §9was unbanned");
                                (new Webhook(self::URL["anticheat"]))
                                    ->send(
                                        (new Message())
                                            ->addEmbed(
                                                (new Embed())
                                                    ->setDescription("**UnBan**\nPlayer : **" . $name
                                                        . "**\nStaff : **" . $sender->getName() . "**\nFrom : **" . $server->getConfigGroup()->getConfigString("name") . "**")
                                                    ->setColor(intval(str_replace("#", "", "#84aafa"), 16))
                                                    ->setFooter("AntiCheat • 1.0.0")
                                                    ->setTimestamp()
                                            )
                                    );

                            } else $sender->sendMessage(self::PREFIX . "The player " . $name . " doesn't exist in banlist !");
                        }
                    }
                ));
            }
        }

        return true;
    }
}