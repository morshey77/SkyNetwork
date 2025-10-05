<?php /** @noinspection PhpInternalEntityUsedInspection */

namespace skynetwork\game\commands;

use pocketmine\command\{CommandSender, defaults\ListCommand as LC};

use pocketmine\lang\KnownTranslationFactory;

use pocketmine\player\Player;

use skynetwork\game\Core;
use skynetwork\game\managers\{game\Game, team\Team};

/** @noinspection PhpUnused */
class ListCommand extends LC
{

    /**
     * @param Core $core
     */
    public function __construct(protected Core $core)
    {
        parent::__construct();

        $core->getServer()->getCommandMap()->register($this->getName(), $this);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if($this->testPermission($sender)) {
            if($sender instanceof Player
                AND ($game = $this->core->getGameManager()->getGame($sender)) instanceof Game
            ) {

                /** @var Game $game  */
                $maxPlayers = array_sum(array_map(function(Team $team): string {
                    return $team->getMaxPlayers();
                }, $game->getTeams()));

                $playerNames = array_merge(array_map(function(Team $team): array {
                    return array_map(function(Player $player): string {
                        return $player->getName();
                    }, $team->all());
                }, $game->getTeams()));

            } else {

                $playerNames = array_map(function(Player $player): string {
                    return $player->getName();
                }, $sender->getServer()->getOnlinePlayers());

                $maxPlayers = $sender->getServer()->getMaxPlayers();

            }

            sort($playerNames, SORT_STRING);

            $sender->sendMessage(KnownTranslationFactory::commands_players_list((string) count($playerNames), (string) $maxPlayers));
            $sender->sendMessage(implode(', ', $playerNames));
        }

        return true;
    }
}