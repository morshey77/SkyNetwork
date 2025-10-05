<?php


namespace Morcheysha77\Faction\Commands\Staff\Sanction\Ban;


use pocketmine\command\CommandSender;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\entity\Entity;

use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;

use pocketmine\network\mcpe\protocol\types\entity\EntityIds;

use Morcheysha77\Faction\Main;
use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Tasks\QueryAsync;

use Morcheysha77\Faction\Commands\Properties\Command;
use Morcheysha77\Faction\Constants\Webhook as WebhookConstant;

use Morcheysha77\Faction\Webhooks\Webhook;
use Morcheysha77\Faction\Webhooks\Message;
use Morcheysha77\Faction\Webhooks\Embed;

use Morcheysha77\Faction\UtilsTraits\Date;

class Ban extends Command implements WebhookConstant
{

    use Date;

    /** @var Main $plugin */
    private Main $plugin;

    /**
     * Ban constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {

        parent::__construct("ban", "Allows to ban a player", "ban <player> <time> ...reason");
        $this->setPermission("pocketmine.command.ban");
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

                $server = $sender->getServer();
                $players = [];
                foreach(scandir($this->plugin->getServer()->getDataPath() . "players/") as $file) {
                    $players[] = rtrim($file, ".dat");
                }
                if(($player = $server->getPlayerByPrefix($args[0])) instanceof FPlayer OR in_array(strtolower($args[0]), $players)) {
                        
                    $name = array_shift($args);

                    if(empty($args[0]) AND $sender instanceof FPlayer) {

                        //FormAPI

                    } elseif(isset($args[0])) {

                        $string = array_shift($args);
                        $time = (str_starts_with($string, "perm") ? -1 : strtotime("+" . str_replace(
                                [
                                    "y",
                                    "n",
                                    "d",
                                    "h",
                                    "m",
                                    "s"
                                ],
                                [
                                    " year ",
                                    " month ",
                                    " day ",
                                    " hour ",
                                    " minute ",
                                    " second "
                                ], $string
                            )));

                        $this->ban($server, $player, $name, $sender->getName(), $time, implode(" ", $args));

                    } else $sender->sendMessage($this->getUsage());
                } else $sender->sendMessage($this->notPlayer($args[0]));
            }
        }

        return true;

    }

    private function ban(Server $server, ?Player $player, string $name, string $staff, int $time, string $reason): void
    {

        $date = $this->format($time === -1 ? $time : ($time - time()));
        $message = self::COMMAND . "\n§9You were banned from §f" . $server->getConfigGroup()->getConfigString("name")
            . "\n§9Staff : §f" . $staff . "\n§9Reason : §f" . $reason;

        if($player instanceof FPlayer) {

            $name = $player->getName();

            $server->broadcastPackets($player->getWorld()->getPlayers(), [
                AddActorPacket::create($runtime = Entity::nextRuntimeId(), $runtime, EntityIds::LIGHTNING_BOLT,
                    $player->getPosition(), null, 0.0, 0.0, 0.0, [], [], []),
                PlaySoundPacket::create("AMBIENT.WEATHER.LIGHTNING.IMPACT", $player->getPosition()->getX(),
                    $player->getPosition()->getY(), $player->getPosition()->getZ(), 3, 5)
            ]);

            $player->kick("anticheat", $message . "\nDuration: " . $date);

        }

        $server->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "REPLACE INTO ban(`player`, `time`, `reason`, `staff`) VALUES ('" . strtolower($name) . "','" . $time . "','" . $reason . "','" . $staff . "');",
            function(){}
        ));

        $server_name = $server->getConfigGroup()->getConfigString("name");

        $server->broadcastMessage(self::COMMAND . "§f" . $name . " §9was ban from §f" . $server_name . "\n§9Staff : §f" . $staff . "\n§9Reason : §f" . $reason);
        (new Webhook(self::URL["anticheat"]))
            ->send(
                (new Message())
                    ->addEmbed(
                        (new Embed())
                            ->setDescription("**Ban**\nPlayer : **" . $name . "**\nStaff : **" . $staff
                                . "**\nFrom : **" . $server_name . "**\nReason : " . $reason . "\nDate : " . $date)
                            ->setColor(intval(str_replace("#", "", "#fd6262"), 16))
                            ->setFooter("AntiCheat • 1.0.0")
                            ->setTimestamp()
                    )
            );
    }

}
