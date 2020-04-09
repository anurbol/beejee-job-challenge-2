<?php $data = \Views\Components\TaskForm::getInstance() ?>
<form action="/tasks/<?= $data->action ?><?= $data->paramsStr ?>" method="post">

    <div class="form-group">
        <input type="text"
               value="<?= $data->username ?>"
               name="username"
               class="form-control"
               placeholder="Имя пользователя">

        <div class="validation-messages"><?= implode("<br>", $data->usernameValidationErrors) ?></div>
    </div>

    <div class="form-group">
        <input type="text"
               value="<?= $data->email ?>"
               name="email"
               class="form-control"
               placeholder="Email">

        <div class="validation-messages"><?= implode("<br>", $data->emailValidationErrors) ?></div>
    </div>

    <textarea name="text" class="form-control" rows="5" placeholder="Текст задачи"><?= $data->text ?></textarea>
    <div class="validation-messages"><?= implode("<br>", $data->textValidationErrors) ?></div>


    <input class="btn btn-primary" type="submit">
</form>