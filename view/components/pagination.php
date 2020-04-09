<?php $view = \Views\Components\TasksTable::getInstance(); ?>
<nav>
    <ul class="pagination">
        <?php while ($paginationItem = $view->paginationIterator->next()) { ?>
        <li class="page-item <?= \Utils\Html::classList([
                'active' => $paginationItem->active,
                'disabled' => $paginationItem->disabled
        ]) ?>">
            <a class="page-link" href="/?<?= \Utils\Url::update(['page' => $paginationItem->targetPage]) ?>">
                <?= $paginationItem->label ?>
            </a>
        </li>
        <?php } ?>
    </ul>
</nav>