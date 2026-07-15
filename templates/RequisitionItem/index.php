<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\RequisitionItem> $requisitionItem
 */
$rowNumber = (int)$this->Paginator->counter('{{start}}');
?>
<div class="requisitionItem index content admin-crud-page requisition-item-admin-page">
    <div class="admin-crud-header">
        <div>
            <h1>Requisition Item Management</h1>
            <p>Review requested items, quantities and approval status.</p>
        </div>
        <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Requisition Item', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
    </div>
    <div class="requisition-item-table-wrapper admin-crud-table-card">
        <table class="table admin-table requisition-item-table">
            <colgroup>
                <col class="ri-no-col">
                <col class="ri-item-col">
                <col class="ri-qty-requested-col">
                <col class="ri-qty-approved-col">
                <col class="ri-status-col">
                <col class="ri-actions-col">
            </colgroup>
            <thead>
                <tr>
                    <th class="number-column"><?= __('No.') ?></th>
                    <th><?= $this->Paginator->sort('item_id', 'Item') ?></th>
                    <th class="qty-requested-cell"><?= $this->Paginator->sort('quantity_requested', 'Qty Requested') ?></th>
                    <th class="qty-approved-cell"><?= $this->Paginator->sort('quantity_approved', 'Qty Approved') ?></th>
                    <th class="status-cell"><?= __('Status') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisitionItem as $requisitionItemEntity): ?>
                <tr>
                    <td class="number-cell"><?= $this->Number->format($rowNumber++) ?></td>
                    <td class="item-cell"><?= $requisitionItemEntity->hasValue('item') ? $this->Html->link($requisitionItemEntity->item->item_name, ['controller' => 'Item', 'action' => 'view', $requisitionItemEntity->item->item_id]) : '-' ?></td>
                    <td class="qty-requested-cell"><?= $this->Number->format($requisitionItemEntity->quantity_requested) ?></td>
                    <td class="qty-approved-cell"><?= $requisitionItemEntity->quantity_approved === null ? '0' : $this->Number->format($requisitionItemEntity->quantity_approved) ?></td>
                    <?php $status = strtolower((string)($requisitionItemEntity->requisition->status ?? 'pending')); ?>
                    <td class="status-cell"><span class="status-badge status-<?= h($status) ?>"><?= h($requisitionItemEntity->requisition->status ?? 'Pending') ?></span></td>
                    <td class="actions actions-cell">
                        <div class="action-group">
                            <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $requisitionItemEntity->requisition_item_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $requisitionItemEntity->requisition_item_id], ['class' => 'action-icon-btn action-edit edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                            <?= $this->Form->postButton(
                                '<i class="bi bi-trash"></i>',
                                ['action' => 'delete', $requisitionItemEntity->requisition_item_id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $requisitionItemEntity->requisition_item_id),
                                    'class' => 'action-icon-btn action-delete delete-btn',
                                    'aria-label' => __('Delete'),
                                    'title' => __('Delete'),
                                    'escapeTitle' => false,
                                ]
                            ) ?>
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
