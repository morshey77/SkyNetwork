<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\world\Position;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\FactionPro\Faction;

use Morcheysha77\Faction\Tasks\QueryAsync;

class FactionManager extends Manager
{

    /** @var array<string, Faction> */
    private array $factions = [];

    /** @var array<string, array<string>> */
    private array $claims = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return "faction";
    }

    public function init(): void
    {

        $this->plugin->getServer()->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "SELECT * FROM faction;",
            function(QueryAsync $self) {

                $result = $self->getResult();

                if(is_array($result)){

                    $faction = strval($result["faction"]);

                    $this->factions[$faction] = new Faction($faction, intval($result["money"]), intval($result["power"]),
                        explode("_", strval($result["allies"])), explode("_", strval($result["members"])));
                    $this->factions[$faction]->setHome(...explode("_", strval($result["home"])));

                    array_map(fn($claim) => $this->claims[$faction][] = $claim, explode(".", strval($result["claims"])));

                }
            }
        ));
    }

    public function disable(): void
    {

        $server = $this->plugin->getServer();
        $values = "";

        foreach ($this->factions as $name => $faction) {

            $values .= "('" . strtolower($name) . "','" . $faction->getMoney() . "','" . $faction->getPower() . "','"
                . implode("_", $faction->getAllies()) . "','" . $faction->getHome() . "','" . implode(".", $this->claims[$name]) ."'),";

        }

        $server->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "DELETE * FROM faction;",
            function(){}
        ));
        $server->getAsyncPool()->submitTask(new QueryAsync(
            "Faction",
            "REPLACE INTO faction(`faction`, `money`, `power`, `allies`, `members`, `home`, `claims`) VALUES " . substr_replace($values ,";",-1),
            function(){}
        ));

    }

    /**
     * @param string $name
     * @return Faction|null
     */
    public function getFaction(string $name): ?Faction
    {
        return $this->factions[$name] ?? null;
    }

    public function createFaction(string $name, string $leader): void
    {

        $this->factions[$name] = new Faction($name);
        $this->factions[$name]->addMember($leader);

    }

    public function removeFaction(string $name): void
    {
        unset($this->factions[$name]);
    }

    /**
     * @param int $x
     * @param int $z
     * @param string $level
     * @return string
     */
    public function getFactionClaim(int $x, int $z, string $level): string
    {

        foreach ($this->claims as $faction => $claims) {
            foreach ($claims as $claim) {
                if ($claim === $x . "_" . $z . "_" . $level) return $faction;
            }
        }

        return "";
    }

    /**
     * @param int $x
     * @param int $z
     * @param string $level
     * @return bool
     */
    public function isClaim(int $x, int $z, string $level): bool
    {
        return $this->getFactionClaim($x, $z, $level) !== "";
    }

    /**
     * @param FPlayer $player
     * @param Position $position
     * @return bool
     */
    public function interactClaim(FPlayer $player, Position $position): bool
    {

        $world = $position->getWorld();

        return $player->isInFaction() AND ((!$this->isClaim($position->getX() >> 4, $position->getZ() >> 4, $world->getFolderName())
                OR $this->getFactionClaim($position->getX() >> 4, $position->getZ() >> 4, $world->getFolderName()) === $player->getFaction()));

    }

    /**
     * @param string $faction
     * @param int $x
     * @param int $z
     * @param string $level
     */
    public function createClaim(string $faction, int $x, int $z, string $level): void
    {
        $this->claims[$faction][] = $x . "_" . $z . "_" . $level;
    }

    /**
     * @param string $faction
     * @param int $x
     * @param int $z
     * @param string $level
     */
    public function removeClaim(string $faction, int $x, int $z, string $level): void
    {
        unset($this->claims[$faction][$x . "_" . $z . "_" . $level]);
    }
}