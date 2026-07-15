<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransaction $stockTransactionEntity
 * @var \Cake\Collection\CollectionInterface|string[] $items
 * @var \Cake\Collection\CollectionInterface|string[] $admins
 */
?>
<section class="admin-form-page admin-form-stock-transaction">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Dashboard'), ['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Stock Transaction'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('Add Stock Transaction') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-arrow-left-right"></i></span>
                <div>
                    <h1><?= __('Add Stock Transaction') ?></h1>
                    <p><?= __('Record stock in, stock out or stock adjustment activity.') ?></p>
                </div>
            </div>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Stock Transaction List'), ['action' => 'index'], ['class' => 'admin-form-back-btn', 'escape' => false]) ?>
    </div>
    <div class="admin-form-card">
        <?= $this->Form->create($stockTransactionEntity, ['class' => 'admin-modern-form']) ?>
            <?= $this->Form->hidden('admin_id', ['value' => $currentUser['id'] ?? null]) ?>
            <div class="admin-form-section-title"><i class="bi bi-arrow-left-right"></i><h2><?= __('Stock Transaction Information') ?></h2></div>
            <div class="admin-form-grid">
                <div class="admin-input-icon"><i class="bi bi-box"></i><?= $this->Form->control('item_id', ['options' => $items]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-person-badge"></i><?= $this->Form->control('_admin_display', ['label' => __('Admin'), 'value' => $currentUser['name'] ?? __('Current Admin'), 'disabled' => true]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-shuffle"></i><?= $this->Form->control('transaction_type', ['options' => $transactionTypes, 'empty' => false]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-123"></i><?= $this->Form->control('quantity', ['type' => 'number', 'min' => 1, 'required' => true]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-calendar-event"></i><?= $this->Form->control('transaction_date', ['empty' => true]) ?></div>
                <div class="admin-input-icon admin-form-span-2"><i class="bi bi-card-text"></i><?= $this->Form->control('remarks') ?></div>
            </div>
            <div class="admin-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'admin-form-cancel']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> ' . __('Create Stock Transaction'), ['class' => 'admin-form-submit', 'escapeTitle' => false]) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
