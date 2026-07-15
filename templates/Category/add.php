<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $categoryEntity
 */
?>
<section class="admin-form-page admin-form-category">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Dashboard'), ['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Category'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('Add Category') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-tags"></i></span>
                <div>
                    <h1><?= __('Add Category') ?></h1>
                    <p><?= __('Create a new category for organizing inventory items.') ?></p>
                </div>
            </div>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Category List'), ['action' => 'index'], ['class' => 'admin-form-back-btn', 'escape' => false]) ?>
    </div>

    <div class="admin-form-card">
        <?= $this->Form->create($categoryEntity, ['class' => 'admin-modern-form']) ?>
            <div class="admin-form-section-title"><i class="bi bi-tag"></i><h2><?= __('Category Information') ?></h2></div>
            <div class="admin-form-grid">
                <div class="admin-input-icon"><i class="bi bi-tag"></i><?= $this->Form->control('category_name', ['label' => __('Category Name') . ' *']) ?></div>
                <div class="admin-input-icon admin-form-span-2"><i class="bi bi-card-text"></i><?= $this->Form->control('description') ?></div>
            </div>
            <div class="admin-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'admin-form-cancel']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> ' . __('Create Category'), ['class' => 'admin-form-submit', 'escapeTitle' => false]) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
