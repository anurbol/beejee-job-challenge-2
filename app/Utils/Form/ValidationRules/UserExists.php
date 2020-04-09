<?php


namespace Utils\Form\ValidationRules;


use Utils\Form\ContexwiseValidationRule;
use Utils\Form\ValidationRule;
use Model\User;

class UserExists extends ContexwiseValidationRule
{
    /**
     * @var User|null
     */
    private ?User $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    public function getMessage(): string
    {
        return 'Пользователь не найден!';
    }

    public function validate($username): bool
    {
        return (bool) $this->user;
    }

    public static function getName(): string
    {
        return 'user_exists';
    }
}