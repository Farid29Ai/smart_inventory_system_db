<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransaction $stockTransactionEntity
 */
$type = strtolower(str_replace(' ', '-', (string)$stockTransactionEntity->transaction_type));
?>
<section class="admin-form-page admin-view-page stock-transaction-view-page">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Stock Transaction'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('View Transaction') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-arrow-left-right"></i></span>
                <div>
                    <h1><?= __('Stock Transaction Details') ?></h1>
                    <p><?= __('Review stock movement and inventory transaction information.') ?></p>
                </div>
            </div>
        </div>
        <div class="admin-form-actions stock-view-actions page-action-group">
            <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Stock Transactions'), ['action' => 'index'], ['class' => 'stock-view-back-btn btn-secondary', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Edit Transaction'), ['action' => 'edit', $stockTransactionEntity->transaction_id], ['class' => 'stock-view-edit-btn btn-primary', 'escape' => false]) ?>
        </div>
    </div>

    <div class="admin-form-card stock-transaction-detail-card">
        <div class="admin-form-section-title">
            <i class="bi bi-receipt"></i>
            <h2><?= __('Transaction Summary') ?></h2>
        </div>

        <div class="admin-detail-grid">
            <article>
                <span><?= __('Transaction ID') ?></span>
                <strong><?= $this->Number->format($stockTransactionEntity->transaction_id) ?></strong>
            </article>
            <article>
                <span><?= __('Item') ?></span>
                <strong>
                    <?= $stockTransactionEntity->hasValue('item')
                        ? $this->Html->link($stockTransactionEntity->item->item_name, ['controller' => 'Item', 'action' => 'view', $stockTransactionEntity->item->item_id])
                        : '-' ?>
                </strong>
            </article>
            <article>
                <span><?= __('Admin') ?></span>
                <strong>
                    <?= $stockTransactionEntity->hasValue('admin')
                        ? $this->Html->link($stockTransactionEntity->admin->admin_name, ['controller' => 'Admin', 'action' => 'view', $stockTransactionEntity->admin->admin_id])
                        : '-' ?>
                </strong>
            </article>
            <article>
                <span><?= __('Transaction Type') ?></span>
                <strong><span class="type-badge type-<?= h($type) ?>"><?= h($stockTransactionEntity->transaction_type) ?></span></strong>
            </article>
            <article>
                <span><?= __('Quantity') ?></span>
                <strong><?= $this->Number->format($stockTransactionEntity->quantity) ?></strong>
            </article>
            <article>
                <span><?= __('Transaction Date') ?></span>
                <strong><?= $stockTransactionEntity->transaction_date ? h($stockTransactionEntity->transaction_date->format('d M Y, h:i A')) : '-' ?></strong>
            </article>
        </div>

        <div class="admin-detail-note">
            <span><?= __('Remarks') ?></span>
            <p><?= $this->Text->autoParagraph(h($stockTransactionEntity->remarks ?: '-')) ?></p>
        </div>
    </div>
</section>
