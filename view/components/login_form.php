<?php $data = \Views\Components\LoginForm::getInstance() ?>
<form action="/auth/login" method="post">

    <div class="form-group">
        <input type="text"
               value="<?= $data->username ?>"
               name="username"
               class="form-control"
               placeholder="Имя пользователя">

        <div class="validation-messages"><?= implode("<br>", $data->usernameValidationErrors) ?></div>
    </div>

    <div class="form-group">
        <input type="password"
               value="<?= $data->password ?>"
               name="password"
               class="form-control"
               placeholder="Пароль">

        <div class="validation-messages"><?= implode("<br>", $data->passwordValidationErrors) ?></div>
    </div>



    <input class="btn btn-primary" type="submit">
</form>