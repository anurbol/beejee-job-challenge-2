<?php $data = \Views\Components\TasksTable::getInstance() ?>
<thead>
<tr>
    <?php while ($column = $data->columnsIter->next()) { ?>
        <th class="sortable" id="column-<?= $column->name ?>" scope="col">
            <a href="/?<?= Utils\Url::update(['order_by' => $column->name, 'order_direction' => $data->orderDirection->get_opposite_str()]) ?>">
                <?= $column->title ?>

                <?php
                (new \Contracts\TasksTable\TableHeaderOrderArrow($column->name, $data->orderBy, $data->orderDirection))->render();
                ?>

            </a>
        </th>
    <?php } ?>
</tr>
</thead>

