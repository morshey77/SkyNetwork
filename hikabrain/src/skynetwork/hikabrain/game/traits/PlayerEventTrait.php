<?php

namespace skynetwork\hikabrain\game\traits;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\event\player\{
    PlayerChatEvent,
    PlayerDropItemEvent,
    PlayerInteractEvent,
    PlayerItemConsumeEvent,
    PlayerMoveEvent
};

use pocketmine\block\Bed;
use pocketmine\player\Player;

trait PlayerEventTrait
{

    /**
     * @param PlayerChatEvent $event
     * @return void
     */
    public function onPlayerChat(PlayerChatEvent $event): void
    {

        $player = $event->getPlayer();

        foreach ($this->getTeams() as $team) {
            if($event->getMessage()[0] === '@') {

                $players = [];
                foreach ($this->getTeams() as $t)
                    foreach ($t->all() as $p)
                        $players[] = $p;

                $event->setMessage(substr($event->getMessage(), 2));

                $team->broadcastMessage('ALL', [$player->getName(), $event->getMessage()], $players);
            } elseif($event->getMessage()[0] !== '@' AND $team->has($player->getUniqueId()->toString()))
                $team->broadcastMessage('TEAM', [$player->getName(), $event->getMessage()]);
        }

        $event->cancel();
    }

    /**
     * @param PlayerDropItemEvent $event
     * @return void
     */
    public function onPlayerDropItem(PlayerDropItemEvent $event): void
    {
        $event->cancel();
    }

    /**
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function onPlayerInteract(PlayerInteractEvent $event): void
    {
		/*
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($item->getTypeId() === VanillaItems::IRON_SWORD()->getTypeId() AND $item->getCustomName() === HikabrainGame::MANAGE_INVENTORY) {

			$inventory = InvMenu::create(InvMenuTypeIds::TYPE_CHEST, $this->spawnsKit[$player->getUniqueId()->toString()]->getInventory());
			$inventory->send($player, HikabrainGame::MANAGE_INVENTORY);

			// TODO: How to prevent the player from removing an item from the menu?

        }
		*/

        if($event->getBlock() instanceof Bed)
            $event->cancel();
    }

    /**
     * @param PlayerItemConsumeEvent $event
     * @return void
     */
    public function onPlayerItemConsume(PlayerItemConsumeEvent $event): void
    {
        ($h = $event->getPlayer()->getHungerManager())->setFood($h->getMaxFood() - 1);
    }

    /**
     * @param PlayerMoveEvent $event
     * @return void
     */
    public function onPlayerMove(PlayerMoveEvent $event): void
    {

        $player = $event->getPlayer();
        $key = $this->getTeam($player)?->getKey() ?? null;

        if($key !== null) {
            if ($event->getTo()->distance($this->getGoalPosition($key)) < 1) {
                if ($player->getWorld()->getBlock($event->getTo()->subtract(0, 0.5, 0)) instanceof Bed) {
                    foreach ($this->getTeams() as $team)
                        foreach ($team->all() as $p)
                            if($p instanceof Player)
                                $this->respawn($p);

                    $this->addPoint($key);
                    $this->clearBlocks();

                    if ($this->getPoint($key) >= $this->getWinPoints())
                        $this->winGame($key);
                }
            }
        }
    }
}
