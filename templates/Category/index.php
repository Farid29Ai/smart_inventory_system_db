<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $category
 */
$rowNumber = (int)$this->Paginator->counter('{{start}}');
?>
<div class="category index content admin-crud-page">
    <div class="admin-crud-header">
        <div>
            <h1>Category Management</h1>
            <p>Organize inventory categories for efficient item tracking.</p>
        </div>
        <?php if (($currentRole ?? null) === 'admin'): ?>
            <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Category', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
        <?php endif; ?>
    </div>
    <div class="table-responsive table-scroll-wrapper admin-crud-table-card">
        <table class="table admin-table">
            <colgroup>
                <col class="category-id-col">
                <col class="category-name-col">
                <col class="category-status-col">
                <col class="category-actions-col">
            </colgroup>
            <thead>
                <tr>
                    <th class="category-id-column"><?= __('ID') ?></th>
                    <th class="category-name-column"><?= $this->Paginator->sort('category_name', 'Category Name') ?></th>
                    <th class="category-status-column"><?= __('Status') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($category as $categoryEntity): ?>
                <tr>
                    <td class="category-id-cell"><?= $this->Number->format($rowNumber++) ?></td>
                    <td class="category-name-cell"><?= h($categoryEntity->category_name) ?></td>
                    <td class="category-status-cell"><span class="status-badge status-active">Active</span></td>
                    <td class="actions-cell">
                        <div class="action-group">
                            <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $categoryEntity->category_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            <?php if (($currentRole ?? null) === 'admin'): ?>
                                <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $categoryEntity->category_id], ['class' => 'action-icon-btn action-edit edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                                <?= $this->Form->postButton(
                                    '<i class="bi bi-trash"></i>',
                                    ['action' => 'delete', $categoryEntity->category_id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $categoryEntity->category_id),
                                        'class' => 'action-icon-btn action-delete delete-btn',
                                        'aria-label' => __('Delete'),
                                        'title' => __('Delete'),
                                        'escapeTitle' => false,
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
