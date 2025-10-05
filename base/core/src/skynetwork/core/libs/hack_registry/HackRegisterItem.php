<?php

namespace skynetwork\core\libs\hack_registry;

use pocketmine\item\{Item, ItemBlock};

use pocketmine\world\format\io\GlobalItemDataHandlers;
use pocketmine\data\bedrock\item\SavedItemData as Data;

use {ReflectionProperty, ReflectionException, InvalidArgumentException, Closure};

readonly class HackRegisterItem
{
    /**
     * HackRegisterItem constructor.
     *
     * @param Item|ItemBlock $item
     * @param string $id
     */
    public function __construct(private Item|ItemBlock $item, private string $id) {}

    /**
     * @param Closure(never) : Data $closure
     * @param bool $isSerializer (true = serializer, false = deserializer)
     * @return void
     * @throws ReflectionException
     * @internal This method is only for internal use.
     */
    private function registerItem(Closure $closure, bool $isSerializer = true): void
    {
        $instance = $isSerializer ? GlobalItemDataHandlers::getSerializer() : GlobalItemDataHandlers::getDeserializer();

        try {

            $this->item instanceof ItemBlock ?
                $instance->mapBlock($this->item, $closure) :
                $instance->map($this->item, $closure);

        } catch (InvalidArgumentException) {

            ($property = new ReflectionProperty($instance,
                ($isSerializer ? ($this->item instanceof ItemBlock ? 'blockI' : 'i') . 'temSerializers' : 'deserializers')
            ))->setAccessible(true);
            $value = $property->getValue($instance);
            $value[$isSerializer ? $this->item->getTypeId() : $this->id] = $closure;
            $property->setValue($instance, $value);

        }
    }

    /**
     * @param Closure(never) : Data $serializer
     * @param Closure(never) : Data $deserializer
     * @return void
     * @throws ReflectionException
     */
    public function registerSerializerAndDeserializerItem(Closure $serializer, Closure $deserializer): void
    {
        foreach ([[true, $serializer], [false, $deserializer]] as [$isSerializer, $closure])
            $this->registerItem($closure, $isSerializer);
    }
}