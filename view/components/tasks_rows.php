<?php $data = \Views\Components\TasksTable::getInstance(); ?>

<tbody>
    <?php while ($task = $data->tasksIter->next()) { ?>
        <tr>
            <th><a id="tasks-table-item-<?= $task->id ?>"><?= $task->id ?></a></th>
            <th><?= $task->username ?></th>
            <th><?= $task->email ?></th>
            <th>
                <?= $task->title ?>

                <?php if ($task->edited_by_admin) { ?>
                    <br><span class="badge badge-primary">Отредактировано администратором</span>
                <?php } ?>

                <?php if ($data->user && $data->user->is_admin) { ?>
                    <br>
                    <?php if ($task->done) { ?>
                        <a href="/tasks/mark_not_done/<?= $task->id ?>" class="btn btn-light btn-sm mt-1">Отметить как не выполненное</a>
                    <?php } else { ?>
                        <a href="/tasks/mark_done/<?= $task->id ?>" class="btn btn-success btn-sm mt-1">Отметить как выполненное</a>
                    <?php } ?>

                    <br>
                    <a href="tasks/edit/<?= $task->id ?>">Редактировать</a>
                <?php } ?>
            </th>
            <th>
                <?php if ($task->done) { ?>
                    <br><span class="badge badge-success">Выполнено</span>
                <?php } ?>
            </th>
        </tr>
    <?php } ?>

</tbody>