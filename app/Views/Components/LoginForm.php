<?php

namespace Views\Components;

use View;

class LoginForm
{
    use View;

    public string $username;
    public string $password;
    public array $usernameValidationErrors;
    public array $passwordValidationErrors;

    public function __construct(string $username, string $password, array $usernameValidationErrors, array $passwordValidationErrors)
    {
        $this->username = $username;
        $this->password = $password;
        $this->usernameValidationErrors = $usernameValidationErrors;
        $this->passwordValidationErrors = $passwordValidationErrors;
    }

    public static function requireTemplate()
    {
        require 'view/components/login_form.php';
    }
}