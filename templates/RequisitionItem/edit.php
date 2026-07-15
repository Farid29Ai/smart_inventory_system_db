<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequisitionItem $requisitionItemEntity
 * @var string[]|\Cake\Collection\CollectionInterface $requisitions
 * @var string[]|\Cake\Collection\CollectionInterface $items
 */
?>
<section class="admin-form-page admin-form-requisition-item">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Dashboard'), ['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Requisition Item'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('Edit Requisition Item') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-pencil-square"></i></span>
                <div>
                    <h1><?= __('Edit Requisition Item') ?></h1>
                    <p><?= __('Update requested and approved item quantities.') ?></p>
                </div>
            </div>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Requisition Item List'), ['action' => 'index'], ['class' => 'admin-form-back-btn', 'escape' => false]) ?>
    </div>
    <div class="admin-form-card requisition-item-form-card">
        <?= $this->Form->create($requisitionItemEntity, ['class' => 'admin-modern-form']) ?>
            <div class="admin-form-section-title requisition-item-section-title">
                <i class="bi bi-list-check"></i>
                <h2><?= __('Requisition Item Information') ?></h2>
            </div>
            <div class="admin-form-grid">
                <div class="admin-input-icon">
                    <i class="bi bi-clipboard-check"></i>
                    <?= $this->Form->control('requisition_id', [
                        'label' => __('Requisition'),
                        'options' => $requisitions,
                        'empty' => false,
                    ]) ?>
                </div>
                <div class="admin-input-icon">
                    <i class="bi bi-box-seam"></i>
                    <?= $this->Form->control('item_id', [
                        'label' => __('Item'),
                        'options' => $items,
                        'empty' => false,
                    ]) ?>
                </div>
                <div class="admin-input-icon">
                    <i class="bi bi-123"></i>
                    <?= $this->Form->control('quantity_requested', [
                        'type' => 'number',
                        'label' => __('Quantity Requested'),
                        'min' => 1,
                        'required' => true,
                    ]) ?>
                </div>
                <div class="admin-input-icon">
                    <i class="bi bi-check2-square"></i>
                    <?= $this->Form->control('quantity_approved', [
                        'type' => 'number',
                        'label' => __('Quantity Approved'),
                    ]) ?>
                </div>
            </div>
            <div class="admin-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'admin-form-cancel']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> ' . __('Save Changes'), ['class' => 'admin-form-submit', 'escapeTitle' => false]) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
