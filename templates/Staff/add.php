<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staffEntity
 */
?>
<section class="admin-form-page admin-form-staff">
    <div class="admin-form-header">
        <div>
            <nav class="admin-form-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Dashboard'), ['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Staff'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('Add Staff') ?></strong>
            </nav>
            <div class="admin-form-title-row">
                <span class="admin-form-title-icon"><i class="bi bi-person-plus"></i></span>
                <div>
                    <h1><?= __('Add Staff') ?></h1>
                    <p><?= __('Create a staff account with department and contact details.') ?></p>
                </div>
            </div>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . __('Back to Staff List'), ['action' => 'index'], ['class' => 'admin-form-back-btn', 'escape' => false]) ?>
    </div>

    <div class="admin-form-card">
        <?= $this->Form->create($staffEntity, ['type' => 'file', 'class' => 'admin-modern-form']) ?>
            <div class="admin-form-section-title">
                <i class="bi bi-people"></i>
                <h2><?= __('Staff Information') ?></h2>
            </div>
            <div class="admin-form-grid">
                <div class="admin-input-icon"><i class="bi bi-person"></i><?= $this->Form->control('staff_name', ['label' => __('Staff Name') . ' *']) ?></div>
                <div class="admin-input-icon"><i class="bi bi-envelope"></i><?= $this->Form->control('email', ['label' => __('Email') . ' *']) ?></div>
                <div class="admin-input-icon"><i class="bi bi-lock"></i><?= $this->Form->control('password', ['label' => __('Password') . ' *']) ?></div>
                <div class="admin-input-icon"><i class="bi bi-telephone"></i><?= $this->Form->control('phone_no', ['label' => __('Phone No')]) ?></div>
                <div class="admin-input-icon"><i class="bi bi-building"></i><?= $this->Form->control('department') ?></div>
                <div class="admin-input-icon"><i class="bi bi-briefcase"></i><?= $this->Form->control('position') ?></div>
                <div class="admin-upload-field">
                    <?= $this->Form->control('profile_image', ['type' => 'file', 'accept' => 'image/*', 'label' => __('Profile Picture')]) ?>
                    <div class="admin-upload-hint"><span><i class="bi bi-cloud-arrow-up"></i></span><div><strong><?= __('Upload profile picture') ?></strong><small><?= __('PNG, JPG or JPEG (Max 2MB)') ?></small></div></div>
                </div>
                <div class="admin-input-icon"><i class="bi bi-calendar-plus"></i><?= $this->Form->control('created_at', ['empty' => true]) ?></div>
            </div>
            <div class="admin-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'admin-form-cancel']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> ' . __('Create Staff'), ['class' => 'admin-form-submit', 'escapeTitle' => false]) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
