<?php if ($user = GlobalContext::getUser()) { ?>
    <?= $user->username ?> <a href="/auth/logout">Выйти</a>
<?php } else { ?>
    <a href="/auth/login">Войти</a>
<?php }
