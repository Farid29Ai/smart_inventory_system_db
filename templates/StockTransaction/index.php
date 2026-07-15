<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\StockTransaction> $stockTransaction
 */
$rowNumber = (int)$this->Paginator->counter('{{start}}');
?>
<div class="stockTransaction index content admin-crud-page stock-transaction-admin-page">
    <div class="admin-crud-header">
        <div>
            <h1>Stock Transaction Management</h1>
            <p>Track stock movement, stock in, stock out and inventory adjustments.</p>
        </div>
        <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Stock Transaction', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
    </div>
    <div class="stock-transaction-card">
        <div class="stock-transaction-table-wrapper">
        <table class="stock-transaction-table">
            <colgroup>
                <col style="width: 6%;">
                <col style="width: 15%;">
                <col style="width: 16%;">
                <col style="width: 13%;">
                <col style="width: 7%;">
                <col style="width: 14%;">
                <col style="width: 14%;">
                <col style="width: 15%;">
            </colgroup>
            <thead>
                <tr>
                    <th class="number-column"><?= __('No.') ?></th>
                    <th><?= $this->Paginator->sort('item_id', 'Item') ?></th>
                    <th><?= $this->Paginator->sort('admin_id', 'Admin') ?></th>
                    <th><?= $this->Paginator->sort('transaction_type', 'Type') ?></th>
                    <th class="quantity-cell"><?= $this->Paginator->sort('quantity', 'Qty') ?></th>
                    <th><?= $this->Paginator->sort('transaction_date', 'Date') ?></th>
                    <th><?= $this->Paginator->sort('remarks', 'Remarks') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stockTransaction as $stockTransactionEntity): ?>
                <tr>
                    <td class="number-cell"><?= $this->Number->format($rowNumber++) ?></td>
                    <td class="item-cell"><?= $stockTransactionEntity->hasValue('item') ? $this->Html->link($stockTransactionEntity->item->item_name, ['controller' => 'Item', 'action' => 'view', $stockTransactionEntity->item->item_id]) : '-' ?></td>
                    <td class="admin-cell"><?= $stockTransactionEntity->hasValue('admin') ? $this->Html->link($stockTransactionEntity->admin->admin_name, ['controller' => 'Admin', 'action' => 'view', $stockTransactionEntity->admin->admin_id]) : '-' ?></td>
                    <?php $type = strtolower(str_replace(' ', '-', (string)$stockTransactionEntity->transaction_type)); ?>
                    <td class="type-cell"><span class="transaction-badge type-badge type-<?= h($type) ?> <?= h($type) ?>"><?= h($stockTransactionEntity->transaction_type) ?></span></td>
                    <td class="quantity-cell"><?= $this->Number->format($stockTransactionEntity->quantity) ?></td>
                    <td class="transaction-date-cell"><?= $stockTransactionEntity->transaction_date ? h($stockTransactionEntity->transaction_date->format('d M Y, h:i A')) : '-' ?></td>
                    <td class="remarks-cell"><?= h($this->Text->truncate((string)$stockTransactionEntity->remarks, 80)) ?></td>
                    <td class="actions-cell">
                        <div class="stock-action-group">
                            <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $stockTransactionEntity->transaction_id], ['class' => 'stock-action-btn stock-view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $stockTransactionEntity->transaction_id], ['class' => 'stock-action-btn stock-edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                            <?= $this->Form->postButton(
                                '<i class="bi bi-trash"></i>',
                                ['action' => 'delete', $stockTransactionEntity->transaction_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $stockTransactionEntity->transaction_id),
                                    'class' => 'stock-action-btn stock-delete-btn',
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
