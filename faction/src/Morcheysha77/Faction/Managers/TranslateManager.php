<?php


namespace Morcheysha77\Faction\Managers;


class TranslateManager extends Manager
{

    /** @var array<string, object> */
    private array $translates = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return "translate";
    }

    public function getAllTranslate(): array
    {
        return $this->translates;
    }

    public function getTranslate(string $lang): object
    {
        return $this->translates[$lang] ?? $this->translates["English"];
    }

    public function addTranslate(string $lang, object $class): void
    {
        $this->translates[$lang] = $class;
    }
}