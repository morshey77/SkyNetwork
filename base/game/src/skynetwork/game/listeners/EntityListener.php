<?php

namespace skynetwork\game\listeners;

use pocketmine\player\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\{
    EntityDamageByEntityEvent,
    EntityDamageEvent,
    EntityItemPickupEvent,
    EntityTeleportEvent,
    ProjectileHitBlockEvent,
    ProjectileHitEntityEvent
};

use skynetwork\game\Core;
use skynetwork\game\events\{GamePlayerDeathByPlayerEvent, GamePlayerDeathEvent};
use skynetwork\game\managers\game\GameState;
use skynetwork\game\managers\game\IGameListener;

readonly class EntityListener implements Listener
{

    /**
     * @param Core $core
     */
    public function __construct(private Core $core)
    {
        $this->core->getServer()->getPluginManager()->registerEvents($this, $this->core);
    }

    /**
     * @param EntityDamageEvent $event
     * @return void
     *
     * @noinspection PhpUnused
     */
    public function EntityDamageEvent(EntityDamageEvent $event): void
    {

        $player = $event->getEntity();

        if($player instanceof Player) {
            if($this->core->getGameManager() !== null) {

                $game = $this->core->getGameManager()->getGame($player);

                if($game instanceof IGameListener) {
                    if($game->getState() === GameState::RUNNING) {
                        if(($event instanceof EntityDamageByEntityEvent AND $event->getDamager() instanceof Player)) {

                            /** @var Player $damager */
                            $damager = $event->getDamager();

                            if($game->getTeam($damager) !== null AND $game->getTeam($player)->has($damager->getUniqueId()->toString()))
                                $event->cancel();
                            else {
                                if(($player->getHealth() - $event->getFinalDamage()) <= 0) {

                                    $ev = new GamePlayerDeathByPlayerEvent($game, $player, $event->getCause(), $damager);
                                    $ev->call();

                                } else
                                    $game->onEntityDamageByEntity($event);
                            }
                        } else if(($player->getHealth() - $event->getFinalDamage()) <= 0 OR $event->getCause() === EntityDamageEvent::CAUSE_VOID) {

                            $ev = new GamePlayerDeathEvent($game, $player, $event->getCause());
                            $ev->call();

                        }
                    } else
                        $event->cancel();
                }
            }
        }
    }

    /**
     * @noinspection PhpUnused
     * @param EntityItemPickupEvent $event
     * @return void
     */
    public function EntityItemPickupEvent(EntityItemPickupEvent $event): void
    {

        $player = $event->getEntity();

        if($player instanceof Player) {
            if($this->core->getGameManager() !== null) {

                $game = $this->core->getGameManager()->getGame($player);

                if($game instanceof IGameListener)
                    $game->onEntityItemPickup($event);
            }
        }
    }

    /**
     * @noinspection PhpUnused
     * @param EntityTeleportEvent $event
     * @return void
     */
    public function EntityTeleportEvent(EntityTeleportEvent $event): void
    {

        $player = $event->getEntity();

        if($player instanceof Player) {
            if($this->core->getGameManager() !== null) {

                $game = $this->core->getGameManager()->getGame($player);

                if($game instanceof IGameListener) {

                    $game->getBossBar()?->getBossBarPacket()->sendBossEventPacket([$player]);
                    $game->onEntityTeleport($event);

                }
            }
        }
    }

    /**
     * @noinspection PhpUnused
     * @param ProjectileHitEntityEvent $event
     * @return void
     */
    public function ProjectileHitEntityEvent(ProjectileHitEntityEvent $event): void
    {

        $player = $event->getEntity()->getOwningEntity();

        if($player instanceof Player) {
            if($this->core->getGameManager() !== null) {

                $game = $this->core->getGameManager()->getGame($player);

                if($game instanceof IGameListener)
                    $game->onProjectileHitEntity($event);
            }
        }
    }

    /**
     * @noinspection PhpUnused
     * @param ProjectileHitBlockEvent $event
     * @return void
     */
    public function ProjectileHitBlockEvent(ProjectileHitBlockEvent $event): void
    {

        $player = $event->getEntity()->getOwningEntity();

        if($player instanceof Player) {
            if($this->core->getGameManager() !== null) {

                $game = $this->core->getGameManager()->getGame($player);

                if($game instanceof IGameListener)
                    $game->onProjectileHitBlock($event);
            }
        }
    }
}