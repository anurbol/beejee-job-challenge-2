<?php


namespace Utils\Form;


class Field {
    public string $name;

    /**
     * @var ContextlessValidationRule[]
     */
    public array $validationRules;

    public function __construct(string $name, array $validationRules)
    {
        $this->name = $name;
        $this->validationRules = $validationRules;
    }
}