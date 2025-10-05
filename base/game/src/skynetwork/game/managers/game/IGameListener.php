<?php

namespace skynetwork\game\managers\game;

use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};
use pocketmine\event\entity\{
    EntityDamageByEntityEvent, EntityItemPickupEvent, EntityTeleportEvent, ProjectileHitBlockEvent, ProjectileHitEntityEvent
};
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\event\player\{PlayerChatEvent, PlayerDropItemEvent, PlayerInteractEvent, PlayerItemConsumeEvent, PlayerMoveEvent};

use skynetwork\game\events\{GamePlayerDeathByPlayerEvent,
    GamePlayerDeathEvent,
    GamePlayerJoinEvent,
    GamePlayerQuitEvent,
    GamePlayerTeamChangeEvent,
    GameStateChangeEvent};

interface IGameListener
{

    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function onBlockBreak(BlockBreakEvent $event): void;

    /**
     * @param BlockPlaceEvent $event
     * @return void
     */
    public function onBlockPlace(BlockPlaceEvent $event): void;

    /**
     * @param EntityDamageByEntityEvent $event
     * @return void
     */
    public function onEntityDamageByEntity(EntityDamageByEntityEvent $event): void;

    /**
     * @param EntityItemPickupEvent $event
     * @return void
     */
    public function onEntityItemPickup(EntityItemPickupEvent $event): void;

    /**
     * @param EntityTeleportEvent $event
     * @return void
     */
    public function onEntityTeleport(EntityTeleportEvent $event): void;

    /**
     * @param ProjectileHitEntityEvent $event
     * @return void
     */
    public function onProjectileHitEntity(ProjectileHitEntityEvent $event): void;

    /**
     * @param ProjectileHitBlockEvent $event
     * @return void
     */
    public function onProjectileHitBlock(ProjectileHitBlockEvent $event): void;

    /**
     * @param CraftItemEvent $event
     * @return void
     */
    public function onCraftItem(CraftItemEvent $event): void;

    /**
     * @param PlayerChatEvent $event
     * @return void
     */
    public function onPlayerChat(PlayerChatEvent $event): void;

    /**
     * @param PlayerDropItemEvent $event
     * @return void
     */
    public function onPlayerDropItem(PlayerDropItemEvent $event): void;

    /**
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function onPlayerInteract(PlayerInteractEvent $event): void;

    /**
     * @param PlayerItemConsumeEvent $event
     * @return void
     */
    public function onPlayerItemConsume(PlayerItemConsumeEvent $event): void;

    /**
     * @param PlayerMoveEvent $event
     * @return void
     */
    public function onPlayerMove(PlayerMoveEvent $event): void;

    /**
     * @param GamePlayerDeathByPlayerEvent $event
     * @return void
     */
    public function onGamePlayerDeathByPlayer(GamePlayerDeathByPlayerEvent $event): void;

    /**
     * @param GamePlayerDeathEvent $event
     * @return void
     */
    public function onGamePlayerDeath(GamePlayerDeathEvent $event): void;

    /**
     * @param GamePlayerJoinEvent $event
     * @return void
     */
    public function onGamePlayerJoin(GamePlayerJoinEvent $event): void;

    /**
     * @param GamePlayerQuitEvent $event
     * @return void
     */
    public function onGamePlayerQuit(GamePlayerQuitEvent $event): void;

    /**
     * @param GamePlayerTeamChangeEvent $event
     * @return void
     */
    public function onGamePlayerTeamChange(GamePlayerTeamChangeEvent $event): void;

    /**
     * @param GameStateChangeEvent $event
     * @return void
     */
    public function onGameStateChange(GameStateChangeEvent $event): void;

}