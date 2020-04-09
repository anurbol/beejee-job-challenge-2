<?php


namespace Utils\Form\ValidationRules;

use Utils\Form\ContexwiseValidationRule;
use Utils\Form\ValidationRule;
use Model\User;

class PasswordCorrect extends ContexwiseValidationRule
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
        return 'Неверный пароль.';
    }

    public function validate($password): bool
    {
        // Если пользователя нет, то и пароль не надо проверять.
        if (!$this->user) {
            return true;
        }

        $salt = '2342nsdfnsgkrt@#$!@^@!@#$fsferyh@#$';
        $hash = hash('sha512', $salt . $password );

        return substr($hash, 0, 64) == $this->user->password;
    }

    public static function getName(): string
    {
        return 'password_exists';
    }
}