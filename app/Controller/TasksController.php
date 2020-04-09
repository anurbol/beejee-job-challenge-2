<?php


namespace Controller;


use Utils\Form\Field;
use Utils\Form\ValidationRules;
use Utils\Form\Validator;
use Model\Task;
use Views\Components\TaskForm;
use Views\Layouts\Main;

class TasksController
{
    public const TASK_CREATED = 'task_created';
    public const TASK_UPDATED = 'task_updated';

    public function create()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                {
                    $form = function () {
                        $username = $_GET['username'] ?? '';
                        $email = $_GET['email'] ?? '';
                        $text = $_GET['text'] ?? '';

                        $errorMessages = Validator::getErrorMessages();

                        $usernameValidationErrors = $errorMessages['username'] ?? [];
                        $emailValidationErrors = $errorMessages['email'] ?? [];
                        $textValidationErrors = $errorMessages['text'] ?? [];
                        $action = \GlobalContext::getAction();

                        $view = new TaskForm($username, $email, $text, $usernameValidationErrors, $emailValidationErrors, $textValidationErrors, $action, '');
                        $view->render();
                    };

                    $view = new Main($form);
                    $view->render();
                }
                break;
            case 'POST':
                {
                    $validator = new Validator([
                        new Field('username', [ValidationRules::required()]),
                        new Field('email', [ValidationRules::required(), ValidationRules::email()]),
                        new Field('text', [ValidationRules::required()]),
                    ]);

                    $validator->validateAndRedirect(null, function ($data) {
                        $task = new Task();
                        $task->username = $data['username'];
                        $task->email = $data['email'];
                        $task->title = $data['text'];
                        $saved = $task->save();

                        if ($saved) {
                            return '/?' . self::TASK_CREATED . '=' . $task->id;
                        } else {
                            throw new \Exception('Произошла ошибка');
                        }
                    });
                }
                break;
        }
    }

    public function edit($id) {
        restrict_access();

        $task = Task::query()->find($id);

        if(!$task) {
            throw new \Exception('Задача не найдена');
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
            {
                $form = function () use ($id, $task) {
                    $errorMessages = Validator::getErrorMessages();

                    $usernameValidationErrors = $errorMessages['username'] ?? [];
                    $emailValidationErrors = $errorMessages['email'] ?? [];
                    $textValidationErrors = $errorMessages['text'] ?? [];
                    $action = \GlobalContext::getAction();

                    $view = new TaskForm($task->username, $task->email, $task->title, $usernameValidationErrors, $emailValidationErrors, $textValidationErrors, $action, '/'.$id);
                    $view->render();
                };

                $view = new Main($form);
                $view->render();
            }
            break;
            case 'POST':
            {
                $validator = new Validator([
                    new Field('username', [ValidationRules::required()]),
                    new Field('email', [ValidationRules::required(), ValidationRules::email()]),
                    new Field('text', [ValidationRules::required()]),
                ]);

                $validator->validateAndRedirect(null, function ($data) use ($id, $task) {
                    $task->username = $data['username'];
                    $task->email = $data['email'];
                    $task->title = $data['text'];
                    $task->edited_by_admin = 1;

                    $saved = $task->save();

                    if ($saved) {
                        return '/?' . self::TASK_UPDATED . '=' . $task->id;
                    } else {
                        throw new \Exception('Произошла ошибка');
                    }
                });
            }
            break;
        }
    }

    public function mark_done($id)
    {
        restrict_access();

        $task = Task::query()->find($id);

        if(!$task) {
            throw new \Exception('Задача не найдена');
        }

        $task->done = 1;
        $saved = $task->save();

        if ($saved) {
            header("Location: ".'/?' . self::TASK_UPDATED . '=' . $task->id);
        } else {
            throw new \Exception('Не удалось сохранить задачу.');
        }
    }

    public function mark_not_done($id)
    {
        restrict_access();

        $task = Task::query()->find($id);

        if(!$task) {
            throw new \Exception('Задача не найдена');
        }

        $task->done = 0;
        $saved = $task->save();

        if ($saved) {
            header("Location: ".'/?' . self::TASK_UPDATED . '=' . $task->id);
        } else {
            throw new \Exception('Не удалось сохранить задачу.');
        }
    }
}

function restrict_access() {
    $user = \GlobalContext::getUser();

    if (!$user) {
        header("Location: /auth/login");
        die;
    } elseif (!$user->is_admin) {
        die('Доступ запрещен');
    }
}