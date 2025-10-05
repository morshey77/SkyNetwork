<?php

namespace skynetwork\core\traits;

use skynetwork\core\managers\Manager;

trait ManagersTrait
{

    /** @var array<string, Manager> $managers */
    protected array $managers = [];

    /**
     * @param string $name
     * @return Manager|null
     */
    public function getManager(string $name): ?Manager
    {
        return (isset($this->managers) AND isset($this->managers[$name])) ? $this->managers[$name] : null;
    }
}