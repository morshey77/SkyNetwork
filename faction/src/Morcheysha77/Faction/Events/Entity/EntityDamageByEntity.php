<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Events\Entity;


use pocketmine\player\GameMode;

use pocketmine\item\ItemIds;

use pocketmine\entity\Living;

use pocketmine\math\Vector3;

use pocketmine\world\particle\FlameParticle;
use pocketmine\world\sound\AnvilFallSound;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use Morcheysha77\Faction\Main;

use Morcheysha77\Faction\Managers\FactionManager;
use Morcheysha77\Faction\Managers\SpawnerManager;

use Morcheysha77\Faction\Player\FPlayer;
use Morcheysha77\Faction\Constants\Command as CommandConstant;

class EntityDamageByEntity implements Listener, CommandConstant
{

    private const TIME = 20;
    /** @var Main $plugin */
    private Main $plugin;

    /**
     * EntityDamageByEntity constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function EntityDamageByEntityEvent(EntityDamageByEntityEvent $event)
    {

        $entity = $event->getEntity();
        $damager = $event->getDamager();
        $level_name = $entity->getWorld()->getFolderName();

        if($entity instanceof FPlayer) {
            
            $ev = new EntityDamageEvent($entity, $event->getCause(), $event->getBaseDamage(), $event->getModifiers());
            $ev->call();
            
            if(!$ev->isCancelled() AND $damager instanceof FPlayer) {
                if(($level_name === "Faction" AND $entity->getPosition()->getFloorX() >= 209
                        AND $entity->getPosition()->getFloorX() <= 288 AND $entity->getPosition()->getFloorZ() >= 247
                        AND $entity->getPosition()->getFloorZ() <= 326)
                    OR ($level_name === "FFA" AND $entity->getPosition()->getFloorX() >= 241
                        AND $entity->getPosition()->getFloorX() <= 247 AND $entity->getPosition()->getFloorZ() >= 239
                        AND $entity->getPosition()->getFloorZ() <= 245
                        AND $entity->getPosition()->getFloorY() >= 73 AND $entity->getPosition()->getFloorY() <= 77)
                    OR $this->peaceFaction($entity, $damager)) $event->cancel();
                elseif($entity->getGamemode() === GameMode::SURVIVAL() AND $damager->getGamemode() === GameMode::SURVIVAL()) {

                    if(!$entity->isFight()) $entity->sendPopup(self::PREFIX . "Vous etes en combat, ne vous deconnectez pas");
                    if(!$damager->isFight()) $damager->sendPopup(self::PREFIX . "Vous etes en combat, ne vous deconnectez pas");

                    $entity->setCombatLogger(self::TIME + time());
                    $damager->setCombatLogger(self::TIME + time());
    
                    if($damager->getInventory()->getItemInHand()->getId() === ItemIds::BONE) {
                        if(mt_rand(0, 16) === 8) {
    
                            $maxX = $entity->getPosition()->getX() + 1;
                            $maxY = $entity->getPosition()->getY() + 1;
                            $maxZ = $entity->getPosition()->getZ() + 1;
    
                            for ($x = $entity->getPosition()->getX() - 1; $x <= $maxX; $x++) {
                                for ($y = $entity->getPosition()->getY() - 1; $y <= $maxY; $y++) {
                                    for ($z = $entity->getPosition()->getZ() - 1; $z <= $maxZ; $z++) {
    
                                        $entity->getWorld()->addParticle(new Vector3($x, $y, $z), new FlameParticle());
    
                                    }
                                }
                            }

                            $entity->getWorld()->addSound(new Vector3($maxX, $maxY, $maxZ), new AnvilFallSound());

                            $event->setKnockBack(1);

                        }
                    }
                }
            }
        } else {
            
            if(($manager = $this->plugin->getManagers("spawner")) !== null) {
                if($manager instanceof SpawnerManager) {
                    
                    if($entity instanceof Living AND $damager instanceof FPlayer AND $manager->isStack($entity)) {
                        
                        $entity->setLastDamageCause($event);
                        if($manager->removeFromStack($entity, $damager)) $event->cancel();
                        $manager->recalculateStackName($entity);
                        
                    }
                }
            }
        }
    }

    private function peaceFaction(FPlayer $entity, FPlayer $damager): bool
    {
        return $entity->isInFaction() AND $damager->isInFaction() AND ($entity->getFaction() === $damager->getFaction()
                OR (($manager = $this->plugin->getManagers("faction")) !== null AND $manager instanceof FactionManager
                    AND $manager->getFaction($entity->getFaction())->isAlly($damager->getFaction())));
    }
}