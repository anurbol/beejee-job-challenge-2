<?php


namespace Utils\Form\ValidationRules;

use Utils\Form\ContextlessValidationRule;

class Email extends ContextlessValidationRule
{
    public function getMessage(): string
    {
        return 'Пожалуйста, введите корректный Email.';
    }

    public function validate($email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}