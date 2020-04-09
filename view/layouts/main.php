<?php $data = \Views\Layouts\Main::getInstance() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeeJee Job Challenge</title>
    <link rel="stylesheet" href="/public/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>

    <?php require "view/components/navbar.php" ?>

    <div class="container mt-4">
        <?= ($data->contentProvider)() ?>
    </div>

    <script src="/public/vendor/jquery/jquery.min.js"></script>
    <script src="/public/vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>