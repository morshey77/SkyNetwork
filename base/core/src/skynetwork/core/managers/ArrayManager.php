<?php

namespace skynetwork\core\managers;

class ArrayManager
{

    /** @var object[] */
    protected array $elements = [];

    /**
     * @return object[]
     */
    public function all(): array
    {
        return $this->elements;
    }

    /**
     * @param string $key
     * @return object|null
     */
    public function get(string $key): ?object
    {
        return $this->elements[$key] ?? null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * @param object $obj
     * @param string $key
     * @return void
     */
    public function add(object $obj, string $key): void
    {
        $this->elements[$key] = $obj;
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        unset($this->elements[$key]);
    }
}