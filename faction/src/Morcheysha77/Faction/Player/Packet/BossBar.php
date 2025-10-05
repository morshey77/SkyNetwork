<?php

/*
     ______     __  __  __  ____  _____   _____ _    _ ________     __
    |  _ \ \   / / |  \/  |/ __ \|  __ \ / ____| |  | |  ____\ \   / /
    | |_) \ \_/ /  | \  / | |  | | |__) | (___ | |__| | |__   \ \_/ /
    |  _ < \   /   | |\/| | |  | |  _  / \___ \|  __  |  __|   \   /
    | |_) | | |    | |  | | |__| | | \ \ ____) | |  | | |____   | |
    |____/  |_|    |_|  |_|\____/|_|  \_\_____/|_|  |_|______|  |_|

*/

namespace Morcheysha77\Faction\Player\Packet;


use pocketmine\Server;

use pocketmine\entity\{Entity, Attribute, AttributeMap, AttributeFactory};

use pocketmine\network\mcpe\protocol\{AddActorPacket, BossEventPacket, SetActorDataPacket, UpdateAttributesPacket};
use pocketmine\network\mcpe\protocol\types\entity\{EntityIds, EntityMetadataCollection, EntityMetadataFlags, EntityMetadataProperties};

use Morcheysha77\Faction\Player\FPlayer;

class BossBar
{

    public const NETWORK_ID = EntityIds::SLIME;

    /** @var FPlayer $player */
    private FPlayer $player;

    /** @var string $title */
    private string $title = "";

    /** @var string $subTitle */
    private string $subTitle = "";

    /** @var int $entityId */
    private int $entityId;

    /** @var AttributeMap $attributeMap */
    private AttributeMap $attributeMap;

    /** @var EntityMetadataCollection $entityMetadataCollection */
    private EntityMetadataCollection $entityMetadataCollection;

    /**
     * BossBar constructor.
     * @param FPlayer $player
     */
    public function __construct(FPlayer $player)
    {

        $this->entityId = Entity::nextRuntimeId();
        $this->player = $player;
        $this->attributeMap = new AttributeMap();

        $this->getAttributeMap()->add(AttributeFactory::getInstance()->get(Attribute::HEALTH)
            ->setMaxValue(100.0)->setMinValue(0.0)->setDefaultValue(100.0));

        $this->entityMetadataCollection = new EntityMetadataCollection();
        $this->getEntityMetadataCollection()->setLong(
            EntityMetadataProperties::FLAGS,
            0 ^ 1 << EntityMetadataFlags::SILENT ^ 1 << EntityMetadataFlags::INVISIBLE
            ^ 1 << EntityMetadataFlags::NO_AI ^ 1 << EntityMetadataFlags::FIRE_IMMUNE
        );
        $this->getEntityMetadataCollection()->setShort(EntityMetadataProperties::MAX_AIR, 400);
        $this->getEntityMetadataCollection()->setString(EntityMetadataProperties::NAMETAG, $this->getFullTitle());
        $this->getEntityMetadataCollection()->setLong(EntityMetadataProperties::LEAD_HOLDER_EID, -1);
        $this->getEntityMetadataCollection()->setFloat(EntityMetadataProperties::SCALE, 0);
        $this->getEntityMetadataCollection()->setFloat(EntityMetadataProperties::BOUNDING_BOX_WIDTH, 0.0);
        $this->getEntityMetadataCollection()->setFloat(EntityMetadataProperties::BOUNDING_BOX_HEIGHT, 0.0);

    }

    /**
     * @return FPlayer
     */
    public function getPlayer(): FPlayer
    {
        return $this->player;
    }

    /**
     * @return Entity|null
     */
    public function getEntity(): ?Entity
    {
        return Server::getInstance()->getWorldManager()->findEntity($this->entityId);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title = ""): self
    {

        $this->title = $title;

        $this->sendEntityDataPacket();
        $this->sendBossTextPacket();

        return $this;
    }

    /**
     * @return string
     */
    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    /**
     * @param string $subTitle
     * @return self
     */
    public function setSubTitle(string $subTitle = "") : self
    {

        $this->subTitle = $subTitle;

        $this->sendEntityDataPacket();
        $this->sendBossTextPacket();

        return $this;
    }

    /**
     * @return string
     */
    public function getFullTitle(): string
    {
        return mb_convert_encoding($this->title . (!empty($this->subTitle) ? "\n\n" . $this->subTitle : ""), 'UTF-8');
    }

    /**
     * @param float $percentage 0-1
     * @return self
     */
    public function setPercentage(float $percentage): self
    {

        $this->getAttributeMap()->get(Attribute::HEALTH)->setValue(floatval(max(0.01, $percentage)) *
            $this->getAttributeMap()->get(Attribute::HEALTH)->getMaxValue(), true, true);

        $this->sendAttributesPacket();
        $this->sendBossHealthPacket();

        return $this;
    }

    /**
     * @return float
     */
    public function getPercentage(): float
    {
        return $this->getAttributeMap()->get(Attribute::HEALTH)->getValue() / 100;
    }

    /**
     * TODO: Only registered players validation
     * Hides the bar from the specified players without removing it.
     * Useful when saving some bandwidth or when you'd like to keep the entity
     */
    public function hideFrom(): void
    {

        $pk = new BossEventPacket();

        $pk->bossActorUniqueId = $this->entityId;
        $pk->eventType = BossEventPacket::TYPE_HIDE;

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

    }

    /**
     * TODO: Only registered players validation
     * Displays the bar to the specified players
     */
    public function showTo(): void
    {
        $pk = new BossEventPacket();

        $pk->bossActorUniqueId = $this->entityId;
        $pk->eventType = BossEventPacket::TYPE_SHOW;

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
    }

    public function sendSpawnPacket(): void
    {

        $pk = new AddActorPacket();

        $pk->actorRuntimeId = $this->entityId;
        $pk->type = static::NETWORK_ID;
        $pk->attributes = $this->getAttributeMap()->getAll();
        $pk->metadata = $this->getPropertyManager()->getAll();
        $pk->position = $this->getPlayer()->getPosition()->asVector3();

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);
    }

    public function sendBossPacket(): void
    {

        $pk = new BossEventPacket();

        $pk->bossActorUniqueId = $this->entityId;
        $pk->eventType = BossEventPacket::TYPE_SHOW;
        $pk->title = $this->getFullTitle();
        $pk->healthPercent = $this->getPercentage();

        $this->getPlayer()->getNetworkSession()->sendDataPacket($this->addDefaults($pk));

    }

    public function sendRemoveBossPacket(): void
    {

        $pk = new BossEventPacket();

        $pk->bossActorUniqueId = $this->entityId;
        $pk->eventType = BossEventPacket::TYPE_HIDE;

        $this->getPlayer()->getNetworkSession()->sendDataPacket($this->addDefaults($pk));

    }

    public function sendBossTextPacket(): void
    {

        $pk = new BossEventPacket();

        $pk->bossActorUniqueId = $this->entityId;
        $pk->eventType = BossEventPacket::TYPE_TITLE;
        $pk->title = $this->getFullTitle();

        $this->getPlayer()->getNetworkSession()->sendDataPacket($this->addDefaults($pk));

    }

    public function sendAttributesPacket(): void
    {

        $pk = new UpdateAttributesPacket();

        $pk->actorRuntimeId = $this->entityId;
        $pk->entries = $this->getAttributeMap()->needSend();

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

    }

    public function sendEntityDataPacket(): void
    {

        $this->getPropertyManager()->setString(EntityMetadataProperties::NAMETAG, $this->getFullTitle());

        $pk = new SetActorDataPacket();

        $pk->metadata = $this->getPropertyManager()->getDirty();
        $pk->actorRuntimeId = $this->entityId;

        $this->getPropertyManager()->clearDirtyProperties();
        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

    }

    public function sendBossHealthPacket(): void
    {

        $pk = new BossEventPacket();

        $pk->bossActorUniqueId = $this->entityId;
        $pk->eventType = BossEventPacket::TYPE_HEALTH_PERCENT;
        $pk->healthPercent = $this->getPercentage();

        $this->getPlayer()->getNetworkSession()->sendDataPacket($pk);

    }

    private function addDefaults(BossEventPacket $pk): BossEventPacket
    {

        $pk->title = $this->getFullTitle();
        $pk->healthPercent = $this->getPercentage();
        $pk->unknownShort = 1;
        $pk->color = 0; //Does not function anyways
        $pk->overlay = 0; //Neither. Typical for Mojang: Copy-pasted from Java edition

        return $pk;
    }

    /**
     * @return AttributeMap
     */
    public function getAttributeMap(): AttributeMap
    {
        return $this->attributeMap;
    }

    /**
     * @return EntityMetadataCollection
     */
    public function getEntityMetadataCollection(): EntityMetadataCollection
    {
        return $this->entityMetadataCollection;
    }
}