<?php


namespace Morcheysha77\Faction\Managers;


use pocketmine\utils\AssumptionFailedError;

class FormManager extends Manager
{

    /** @var array<string, object> */
    private array $formui = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return "formui";
    }

    /**
     * @param string $form
     * @return object
     */
    public function getFormUI(string $form): object
    {

        if(empty($formui = $this->formui[$form])) throw new AssumptionFailedError("FormUI is not defined");

        return $formui;
    }

    public function addFormUI(string $form, object $class): void
    {
        $this->formui[$form] = $class;
    }
}