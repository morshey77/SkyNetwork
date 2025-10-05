<?php


namespace Morcheysha77\Faction\Player\Traits;


use JetBrains\PhpStorm\Pure;

trait Faction
{

    /** @var string $faction */
    protected string $faction;
    /** @var string $faction_rank */
    protected string $faction_rank;

    /**
     * @return string
     */
    public function getFaction(): string
    {
        return $this->faction ?? "No Faction";
    }

    /**
     * @return string
     */
    #[Pure] public function getSaveFaction(): string
    {

        return $this->getFaction() . "_" . $this->getFactionRank();
    }

    /**
     * @return bool
     */
    public function isInFaction(): bool
    {
        return isset($this->faction) AND $this->faction !== "No Faction";
    }

    /**
     * @param string $faction
     */
    public function setFaction(string $faction): void
    {
        $this->faction = $faction;
    }

    /**
     * @return string
     */
    public function getFactionRank(): string
    {
        return $this->faction_rank ?? "Player";
    }

    /**
     * @return bool
     */
    #[Pure] public function isOfficer(): bool
    {
        return $this->isInFaction() AND $this->faction_rank === "Officer";
    }

    /**
     * @return bool
     */
    #[Pure] public function isOwner(): bool
    {
        return $this->isInFaction() AND $this->faction_rank === "Owner";
    }

    /**
     * @param string $faction_rank
     */
    public function setFactionRank(string $faction_rank): void
    {
        $this->faction_rank = $faction_rank;
    }
}