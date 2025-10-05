<?php

namespace skynetwork\core\libs\hack_registry;

use pocketmine\block\{Block, RuntimeBlockStateRegistry};
use pocketmine\world\format\io\GlobalBlockStateHandlers;
use {ReflectionException, ReflectionMethod, ReflectionProperty, InvalidArgumentException, Closure};

readonly class HackRegisterBlock
{

    /**
     * HackRegisterBlock constructor.
     *
     * @param Block $block
     */
    public function __construct(private Block $block) {}

    /**
     * @param Closure $serializer
     * @return void
     * @throws ReflectionException
     */
    private function registerBlockSerializer(Closure $serializer): void
    {
        $instance = GlobalBlockStateHandlers::getSerializer();
        try {
            $instance->map($this->block, $serializer);
        } catch (InvalidArgumentException) {
            $serializerProperty = new ReflectionProperty($instance, 'serializers');
            $serializerProperty->setAccessible(true);
            $value = $serializerProperty->getValue($instance);
            $value[$this->block->getTypeId()] = $serializer;
            $serializerProperty->setValue($instance, $value);
        }
    }

    /**
     * @param string $id
     * @param Closure $deserializer
     * @return void
     * @throws ReflectionException
     */
    private function registerBlockDeserializer(string $id, Closure $deserializer): void
    {
        $instance = GlobalBlockStateHandlers::getDeserializer();
        try {
            $instance->map($id, $deserializer);
        } catch (InvalidArgumentException) {
            $deserializerProperty = new ReflectionProperty($instance, 'deserializeFuncs');
            $deserializerProperty->setAccessible(true);
            $value = $deserializerProperty->getValue($instance);
            $value[$id] = $deserializer;
            $deserializerProperty->setValue($instance, $value);
        }
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    private function registerRuntimeBlockStateRegistry(): void
    {
        $instance = RuntimeBlockStateRegistry::getInstance();
        try {
            $instance->register($this->block);
        } catch (InvalidArgumentException) {
            $typeIndexProperty = new ReflectionProperty($instance, 'typeIndex');
            $typeIndexProperty->setAccessible(true);
            $value = $typeIndexProperty->getValue($instance);
            $value[$this->block->getTypeId()] = $this->block;
            $typeIndexProperty->setValue($instance, $value);

            $fillStaticArraysMethod = new ReflectionMethod($instance, 'fillStaticArrays');
            $fillStaticArraysMethod->setAccessible(true);
            foreach ($this->block->generateStatePermutations() as $v) {
                $fillStaticArraysMethod->invoke($instance, $v->getStateId(), $v);
            }
        }
    }

    /**
     * @param string $id
     * @param Closure $serializer
     * @param Closure $deserializer
     * @return void
     * @throws ReflectionException
     */
    public function registerBlockAndSerializerAndDeserializer(string $id, Closure $serializer, Closure $deserializer): void
    {
        $this->registerRuntimeBlockStateRegistry();
        $this->registerBlockSerializer($serializer);
        $this->registerBlockDeserializer($id, $deserializer);
    }
}