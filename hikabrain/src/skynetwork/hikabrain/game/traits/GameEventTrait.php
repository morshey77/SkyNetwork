<?php

namespace skynetwork\hikabrain\game\traits;

use pocketmine\player\Player;
use pocketmine\event\entity\EntityDamageEvent;

use pocketmine\block\VanillaBlocks;
use pocketmine\color\Color;

use pocketmine\item\{enchantment\EnchantmentInstance, enchantment\VanillaEnchantments, VanillaItems};

use skynetwork\core\libs\kit\Kit;

use skynetwork\game\{events\GamePlayerDeathByPlayerEvent,
    events\GamePlayerDeathEvent,
    events\GamePlayerJoinEvent,
    events\GamePlayerQuitEvent,
    events\GamePlayerTeamChangeEvent,
    events\GameStateChangeEvent,
    managers\game\GameState};

trait GameEventTrait
{

    /**
     * @param GamePlayerDeathByPlayerEvent $event
     * @return void
     */
    public function onGamePlayerDeathByPlayer(GamePlayerDeathByPlayerEvent $event): void
    {
        foreach ($event->getGame()->getTeams() as $team)
            if($event->getCause() === EntityDamageEvent::CAUSE_ENTITY_ATTACK)
                $team->broadcastMessage('CAUSE_ENTITY_ATTACK', [$event->getPlayer()->getName(), $event->getDamager()->getName()]);

        $this->respawn($event->getPlayer());
        $event->getTeam()->broadcastTitle('RESPAWN_TITLE', null, [$event->getPlayer()]);

    }

    /**
     * @param GamePlayerDeathEvent $event
     * @return void
     */
    public function onGamePlayerDeath(GamePlayerDeathEvent $event): void
    {
        foreach ($event->getGame()->getTeams() as $team)
            if($event->getCause() === EntityDamageEvent::CAUSE_VOID)
                $team->broadcastMessage('CAUSE_VOID', [$event->getPlayer()->getName()]);

        $this->respawn($event->getPlayer());
        $event->getTeam()->broadcastTitle('RESPAWN_TITLE', null, [$event->getPlayer()]);

    }

    /**
     * @param GamePlayerJoinEvent $event
     * @return void
     */
    public function onGamePlayerJoin(GamePlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        foreach ($event->getGame()->getTeams() as $team)
            $team->broadcastMessage('JOIN_GAME', [$player->getName()]);

        ($h = $player->getHungerManager())->setEnabled(false);
        $h->setFood($h->getMaxFood() - 1);

        $player->teleport($this->getArena()->getWaitPosition());
        $this->waitKit->kit($player);

    }

    /**
     * @param GamePlayerQuitEvent $event
     * @return void
     */
    public function onGamePlayerQuit(GamePlayerQuitEvent $event): void
    {

        $player = $event->getPlayer();

        $this->getTeam($player)?->remove($player->getUniqueId()->toString());

        $i = 0;

        foreach ($event->getGame()->getTeams() as $team) {
            if (count($team->all()) > 0) {

                $team->broadcastMessage('LEAVE_GAME', [$player->getName()]);
                $i++;

            }
        }

        if ($i <= 1)
			$this->winGame(array_key_first($event->getGame()->getTeams()));
    }

    /**
     * @param GamePlayerTeamChangeEvent $event
     * @return void
     */
    public function onGamePlayerTeamChange(GamePlayerTeamChangeEvent $event): void
    {
        $player = $event->getPlayer();

        $color = $this->colors[$event->getNewTeam()->getKey()] ?? new Color(206, 252, 174, 1);

        $this->spawnsKit[$player->getUniqueId()->toString()] = (new Kit())->add(
            VanillaItems::GOLDEN_APPLE()->setCount(64),
            VanillaItems::IRON_SWORD()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 3))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3)),
            VanillaItems::IRON_PICKAXE()
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 3))
                ->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3)),
            VanillaBlocks::SANDSTONE()->asItem()->setCount(1984)
        )
            ->setHelmet(VanillaItems::LEATHER_CAP()->setCustomColor($color))
            ->setChestplate(VanillaItems::LEATHER_TUNIC()->setCustomColor($color))
            ->setLeggings(VanillaItems::LEATHER_PANTS()->setCustomColor($color))
            ->setBoots(VanillaItems::LEATHER_BOOTS()->setCustomColor($color));

        var_dump(array_keys($this->spawnsKit));

    }

    /**
     * @param GameStateChangeEvent $event
     * @return void
     */
    public function onGameStateChange(GameStateChangeEvent $event): void
    {
		switch ($event->getNewState()) {
			case GameState::STARTING:
				$this->countdown = self::COUNTDOWN_DEFAULT;
				break;
			case GameState::RUNNING:
				foreach ($event->getGame()->getTeams() as $team)
					foreach ($team->all() as $player)
						if($player instanceof Player)
							$this->respawn($player);
				break;
			default:
				break;
		}
    }
}