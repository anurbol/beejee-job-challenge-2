<?php


namespace Utils\Form;


use Utils\Form\ValidationRules\Email;
use Utils\Form\ValidationRules\PasswordCorrect;
use Utils\Form\ValidationRules\Required;
use Utils\Form\ValidationRules\UserExists;

class ValidationRules
{
    private static ContextlessValidationRule $required;
    private static ContextlessValidationRule $email;

    public const CONTEXTWISE_RULES = [
        UserExists::class,
        PasswordCorrect::class
    ];

    public static function required()
    {
        return self::$required ??= new Required(__FUNCTION__);
    }

    public static function email()
    {
        return self::$email ??= new Email(__FUNCTION__);
    }
}