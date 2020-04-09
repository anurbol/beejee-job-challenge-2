<?php if($id = $_GET[\Controller\TasksController::TASK_CREATED] ?? null) { ?>
    <div class="alert alert-success" role="alert">
        Задача №<?= $id ?> создана
    </div>
<?php } ?>

<?php if($id = $_GET[\Controller\TasksController::TASK_UPDATED] ?? null) { ?>
    <div class="alert alert-success" role="alert">
        Задача №<?= $id ?> обновлена
    </div>
<?php } ?>

<a href="/tasks/create" class="btn btn-primary mb-3">Новая задача</a>

<table class="table">
    <?php require 'view/components/tasks_header.php' ?>
    <?php require 'view/components/tasks_rows.php' ?>
</table>

<?php require 'view/components/pagination.php' ?>