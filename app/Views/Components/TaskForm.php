<?php

namespace Views\Components;

use View;

class TaskForm
{
    use View;


    /**
     * @var string
     */
    public string $username;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $text;
    /**
     * @var array
     */
    public array $usernameValidationErrors;
    /**
     * @var array
     */
    public array $emailValidationErrors;
    /**
     * @var array
     */
    public array $textValidationErrors;
    /**
     * @var string
     */
    public string $action;
    /**
     * @var string
     */
    public string $paramsStr;

    public function __construct(string $username,
                                string $email,
                                string $text,
                                array $usernameValidationErrors,
                                array $emailValidationErrors,
                                array $textValidationErrors,
                                string $action,
                                string $paramsStr
)
    {
        $this->username = $username;
        $this->email = $email;
        $this->text = $text;
        $this->usernameValidationErrors = $usernameValidationErrors;
        $this->emailValidationErrors = $emailValidationErrors;
        $this->textValidationErrors = $textValidationErrors;
        $this->action = $action;
        $this->paramsStr = $paramsStr;
    }

    public static function requireTemplate()
    {
        require 'view/components/task_form.php';
    }
}