<?php


namespace Morcheysha77\Faction\Managers;


class TpaManager extends Manager
{

    /** @var array<string, string> $request */
    private array $request = [];

    /**
     * @return string
     */
    public function getName(): string 
    {
        return "tpa";
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isRequest(string $name): bool
    {
        return $this->getRequestTpa($name) !== null OR $this->getRequestHere($name) !== null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getRequestTpa(string $name): ?string
    {
        foreach (array_keys($this->request) as $key) {
            if($this->request[$key] === $name) return $key;
        }

        return null;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getRequestHere(string $name): ?string
    {
        return (isset($this->request) AND isset($this->request[$name])) ? $name : null;
    }

    /**
     * @param string $name
     * @param string $victim
     */
    public function setRequestTpa(string $name, string $victim): void
    {
        $this->request[$victim] = $name;
    }

    /**
     * @param string $name
     * @param string $victim
     */
    public function setRequestHere(string $name, string $victim): void
    {
        $this->request[$name] = $victim;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function removeRequest(string $name): bool
    {

        if(($r = $this->getRequestHere($name)) !== null OR ($r = $this->getRequestTpa($name)) !== null) {

            unset($this->request[$r]);
            return true;

        }

        return false;
    }
}