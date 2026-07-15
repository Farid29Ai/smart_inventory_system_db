<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $itemEntity
 * @var string[]|\Cake\Collection\CollectionInterface $categories
 * @var string[]|\Cake\Collection\CollectionInterface $vendors
 * @var string[]|\Cake\Collection\CollectionInterface $requisition
 */
?>
<section class="admin-form-page admin-form-item">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Dashboard'), ['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Item Catalog'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('Edit Item Catalog') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-pencil-square"></i></span>
                <div>
                    <h1><?= __('Edit Item Catalog') ?></h1>
                    <p><?= __('Update item details, stock level, image and supplier information.') ?></p>
                </div>
            </div>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Item Catalog'), ['action' => 'index'], ['class' => 'admin-form-back-btn', 'escape' => false]) ?>
    </div>

    <div class="admin-form-card">
        <?= $this->Form->create($itemEntity, ['type' => 'file', 'class' => 'admin-modern-form']) ?>
            <div class="admin-form-section-title"><i class="bi bi-box"></i><h2><?= __('Item Catalog Information') ?></h2></div>
            <?php if (!empty($itemEntity->item_image)): ?>
                <div class="admin-current-image">
                    <?= $this->Html->image($itemEntity->item_image, ['alt' => $itemEntity->item_name, 'class' => 'admin-current-item-image']) ?>
                    <div><strong><?= h($itemEntity->item_name) ?></strong><span><?= __('Current item image') ?></span></div>
                </div>
            <?php endif; ?>
            <div class="admin-form-grid">
                <div class="admin-input-icon"><i class="bi bi-box-seam"></i><?= $this->Form->control('item_name', ['label' => __('Item Catalog Name') . ' *']) ?></div>
                <div class="admin-input-icon"><i class="bi bi-tags"></i><?= $this->Form->control('category_id', ['options' => $categories, 'empty' => true]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-building"></i><?= $this->Form->control('vendor_id', ['options' => $vendors, 'empty' => true]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-123"></i><?= $this->Form->control('quantity_available') ?></div>
                <div class="admin-input-icon"><i class="bi bi-exclamation-triangle"></i><?= $this->Form->control('minimum_stock') ?></div>
                <div class="admin-input-icon"><i class="bi bi-rulers"></i><?= $this->Form->control('unit') ?></div>
                <div class="admin-upload-field">
                    <?= $this->Form->control('item_image', ['type' => 'file', 'accept' => 'image/*', 'label' => __('Item Catalog Image')]) ?>
                    <div class="admin-upload-hint"><span><i class="bi bi-image"></i></span><div><strong><?= __('Upload item image') ?></strong><small><?= __('PNG, JPG or JPEG (Max 2MB)') ?></small></div></div>
                </div>
                <div class="admin-input-icon"><i class="bi bi-activity"></i><?= $this->Form->control('status') ?></div>
                <div class="admin-input-icon"><i class="bi bi-calendar-plus"></i><?= $this->Form->control('created_at', ['empty' => true]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-calendar-check"></i><?= $this->Form->control('updated_at', ['empty' => true]) ?></div>
                <div class="admin-input-icon admin-form-span-2"><i class="bi bi-card-text"></i><?= $this->Form->control('description') ?></div>
                <div class="admin-input-icon admin-form-span-2"><i class="bi bi-clipboard-check"></i><?= $this->Form->control('requisition._ids', ['options' => $requisition]) ?></div>
            </div>
            <div class="admin-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'admin-form-cancel']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> ' . __('Save Changes'), ['class' => 'admin-form-submit', 'escapeTitle' => false]) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
