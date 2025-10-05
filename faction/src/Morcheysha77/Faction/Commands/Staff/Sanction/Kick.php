<?php


namespace Morcheysha77\Faction\Commands\Staff\Sanction;


use pocketmine\command\CommandSender;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Commands\Properties\Command;
use Morcheysha77\Faction\Constants\Webhook as WebhookConstant;

use Morcheysha77\Faction\Forms\FormAPI\CustomForm;

use Morcheysha77\Faction\Webhooks\Webhook;
use Morcheysha77\Faction\Webhooks\Message;
use Morcheysha77\Faction\Webhooks\Embed;

class Kick extends Command implements WebhookConstant
{

    /**
     * Kick constructor.
     */
    public function __construct()
    {

        parent::__construct("kick", "Allows to kick a player", "kick <player> ...reason");
        $this->setPermission("pocketmine.command.kick");

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
            if($sender instanceof FPlayer) {

                $form = new CustomForm(function(FPlayer $sender, array $data = null) {
                    if(is_array($data) AND isset($data[0])) {
                        if(($p = $this->isPlayerSilent($sender->getServer()->getPlayerByPrefix($data[0]))) !== null)
                            $this->kick($p, $data[1] ?? "", $sender->getName());
                        else
                            $sender->sendMessage($this->notPlayer($data[0]));
                    }
                });

                $form->setTitle("§l§9- §fKick §9-");
                $form->addDropdown("Players : ", $sender->getServer()->getOnlinePlayers());
                $form->addInput("", "...Reason");

                $sender->sendForm($form);

            } else {
                if(empty($args) OR empty($args[0]) OR empty($args[1])) $sender->sendMessage($this->getUsage());
                elseif(($p = $this->isPlayerSilent($sender->getServer()->getPlayerByPrefix($args[0]))) !== null) {

                    array_shift($args);
                    $this->kick($p, implode(" ", $args), $sender->getName());

                } else $sender->sendMessage($this->notPlayer($args[0]));
            }
        }

        return true;
    }

    private function kick(FPlayer $player, string $reason, string $staff): void
    {

        $server = $player->getServer();
        $player->kick("anticheat", self::COMMAND . "\n§9You were kicked \n§9Staff : §f" . $staff . "\n§9Reason : §f" . $reason);
        $server->broadcastMessage(self::COMMAND . "§f" . $player->getName() . " §9was kick \n§9Staff : §f" . $staff . "\n§9Reason : §f" . $reason);

        (new Webhook(self::URL["anticheat"]))
            ->send(
                (new Message())
                    ->addEmbed(
                        (new Embed())
                            ->setDescription("**Kick**\nPlayer : **" . $player->getName() . "**\nStaff : **"
                                . $staff . "**\nFrom : **" . $server->getConfigGroup()->getConfigString("name") . "**\nReason : " . $reason)
                            ->setColor(intval(str_replace("#", "", "#ffae00"), 16))
                            ->setFooter("AntiCheat • 1.0.0")
                            ->setTimestamp()
                    )
            );

    }
}