<?php

namespace Controller;

use Utils\Form\Field;
use Utils\Form\ValidationRules;
use Utils\Form\ValidationRules\PasswordCorrect;
use Utils\Form\ValidationRules\UserExists;
use Utils\Form\Validator;
use Model\Session;
use Model\User;
use Views\Components\LoginForm;
use Views\Layouts\Main;

class AuthController
{
    public const SESSION_COOKIE = 'BEEJEE_SESSION';

    function login()
    {
        // Перенаправить на главную, если пользователь уже вошёл.
        if (\GlobalContext::getSession()) {
            header("Location: /");
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                {
                    $loginForm = function () {
                        $username = $_GET['username'] ?? '';
                        $password = $_GET['password'] ?? '';

                        $errorMessages = Validator::getErrorMessages();

                        $usernameValidationErrors = $errorMessages['username'] ?? [];
                        $passwordValidationErrors = $errorMessages['password'] ?? [];

                        $view = new LoginForm($username, $password, $usernameValidationErrors, $passwordValidationErrors);
                        $view->render();
                    };

                    $view = new Main($loginForm);
                    $view->render();
                }
                break;
            case 'POST':
                {
                    /**
                     * @var $user User|null
                     */
                    $user = ($username = $_POST['username'] ?? null)
                        ? \Model\User::query()->where('username', $username)->first()
                        : null;

                    // Первый валидатор проверяет заполнены ли поля.
                    $firstPhase = new Validator([
                        new Field('username', [ValidationRules::required()]),
                        new Field('password', [ValidationRules::required()]),
                    ]);

                    $firstPhase->validateAndRedirect('/', function () use ($user) {

                        // Второй валидатор проверяет есть ли пользователь и правильный ли пароль.
                        $secondPhase = new Validator([
                            new Field('username', [new UserExists($user)]),
                            new Field('password', [new PasswordCorrect($user)]),
                        ]);

                        $secondPhase->validateAndRedirect('/', function () use ($user) {
                            if ($user) {
                                $user_agent_hash = substr(hash('sha512', $_SERVER['HTTP_USER_AGENT']), 0, 30);
                                $session_key = generate_sesion_key(30);

                                $session = new Session();
                                $session->user_id = $user->id;
                                $session->user_agent_hash = $user_agent_hash;
                                $session->session_key = $session_key;
                                $session_created = $session->save();

                                if ($session_created) {
                                    setcookie(AuthController::SESSION_COOKIE, $session_key, 0, '/');
                                } else {
                                    throw new \Exception("Не удалось создать сессию.");
                                }
                            }
                        });

                        return $secondPhase;
                    });
                }
                break;
        }
    }

    public function logout()
    {
        setcookie(self::SESSION_COOKIE, '', time() - 3600, '/');
        header("Location: /");
    }
}

function generate_sesion_key($strength = 16)
{

    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}