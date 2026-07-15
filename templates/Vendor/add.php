<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vendor $vendorEntity
 */
?>
<section class="admin-form-page admin-form-vendor">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Dashboard'), ['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Vendor'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('Add Vendor') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-building-add"></i></span>
                <div>
                    <h1><?= __('Add Vendor') ?></h1>
                    <p><?= __('Create supplier information and contact details.') ?></p>
                </div>
            </div>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Vendor List'), ['action' => 'index'], ['class' => 'admin-form-back-btn', 'escape' => false]) ?>
    </div>

    <div class="admin-form-card">
        <?= $this->Form->create($vendorEntity, ['class' => 'admin-modern-form']) ?>
            <div class="admin-form-section-title"><i class="bi bi-building"></i><h2><?= __('Vendor Information') ?></h2></div>
            <div class="admin-form-grid">
                <div class="admin-input-icon"><i class="bi bi-building"></i><?= $this->Form->control('vendor_name', ['label' => __('Vendor Name') . ' *']) ?></div>
                <div class="admin-input-icon"><i class="bi bi-person-lines-fill"></i><?= $this->Form->control('contact_person') ?></div>
                <div class="admin-input-icon"><i class="bi bi-telephone"></i><?= $this->Form->control('phone_no') ?></div>
                <div class="admin-input-icon"><i class="bi bi-envelope"></i><?= $this->Form->control('email') ?></div>
                <div class="admin-input-icon admin-form-span-2"><i class="bi bi-geo-alt"></i><?= $this->Form->control('address') ?></div>
            </div>
            <div class="admin-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'admin-form-cancel']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> ' . __('Create Vendor'), ['class' => 'admin-form-submit', 'escapeTitle' => false]) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
