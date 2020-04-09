<?php


namespace Utils\Form\ValidationRules;

use Utils\Form\ContextlessValidationRule;

class Required extends ContextlessValidationRule
{
    public function getMessage(): string
    {
        return 'Это поле обязательно.';
    }

    public function validate($value): bool
    {
        return (bool) $value;
    }
}