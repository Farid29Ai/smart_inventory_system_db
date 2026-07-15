<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionItem $requisitionItemEntity
 */
$statusLabel = (string)($requisitionItemEntity->requisition->status ?? 'Pending');
$statusClass = strtolower($statusLabel);
?>
<div class="category-view-page requisition-item-view-page">
    <div class="view-breadcrumb">
        <?= $this->Html->link(__('Requisition Item'), ['action' => 'index']) ?>
        <span>/</span>
        <strong><?= __('View Item') ?></strong>
    </div>

    <div class="view-header">
        <div>
            <h1 class="view-title"><?= __('Requisition Item Details') ?></h1>
            <p class="view-subtitle"><?= __('Review requested item quantity and approval information.') ?></p>
        </div>

        <div class="view-actions">
            <?= $this->Html->link(
                '<i class="bi bi-arrow-left"></i> ' . __('Back to List'),
                ['action' => 'index'],
                ['class' => 'btn-back', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="bi bi-plus-lg"></i> ' . __('New Requisition Item'),
                ['action' => 'add'],
                ['class' => 'btn-new', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="bi bi-pencil-square"></i> ' . __('Edit Item'),
                ['action' => 'edit', $requisitionItemEntity->requisition_item_id],
                ['class' => 'btn-edit', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="bi bi-trash"></i> ' . __('Delete Item'),
                ['action' => 'delete', $requisitionItemEntity->requisition_item_id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $requisitionItemEntity->requisition_item_id),
                    'class' => 'btn-delete',
                    'escape' => false,
                ]
            ) ?>
        </div>
    </div>

    <section class="view-card">
        <h2 class="view-card-title">
            <i class="bi bi-list-check"></i>
            <?= __('Request Item Summary') ?>
        </h2>

        <div class="info-grid">
            <div class="info-box">
                <span class="info-label"><?= __('Requisition Item ID') ?></span>
                <span class="info-value"><?= $this->Number->format($requisitionItemEntity->requisition_item_id) ?></span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Status') ?></span>
                <span class="info-value">
                    <span class="status-badge status-<?= h($statusClass) ?>"><?= h($statusLabel) ?></span>
                </span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Requisition') ?></span>
                <span class="info-value">
                    <?= $requisitionItemEntity->hasValue('requisition')
                        ? $this->Html->link($requisitionItemEntity->requisition->requisition_id, ['controller' => 'Requisition', 'action' => 'view', $requisitionItemEntity->requisition->requisition_id])
                        : '-' ?>
                </span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Item') ?></span>
                <span class="info-value">
                    <?= $requisitionItemEntity->hasValue('item')
                        ? $this->Html->link($requisitionItemEntity->item->item_name, ['controller' => 'Item', 'action' => 'view', $requisitionItemEntity->item->item_id])
                        : '-' ?>
                </span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Quantity Requested') ?></span>
                <span class="info-value"><?= $this->Number->format($requisitionItemEntity->quantity_requested) ?></span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Quantity Approved') ?></span>
                <span class="info-value"><?= $requisitionItemEntity->quantity_approved === null ? '0' : $this->Number->format($requisitionItemEntity->quantity_approved) ?></span>
            </div>
        </div>
    </section>
</div>
