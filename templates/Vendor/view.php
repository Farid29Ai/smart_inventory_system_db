<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vendor $vendorEntity
 */
?>
<div class="category-view-page vendor-view-page">
    <div class="view-breadcrumb">
        <?= $this->Html->link(__('Vendor'), ['action' => 'index']) ?>
        <span>/</span>
        <strong><?= __('View Vendor') ?></strong>
    </div>

    <div class="view-header">
        <div>
            <h1 class="view-title"><?= h($vendorEntity->vendor_name) ?></h1>
            <p class="view-subtitle"><?= __('View supplier contact information and vendor details.') ?></p>
        </div>

        <div class="view-actions">
            <?= $this->Html->link(
                '<i class="bi bi-arrow-left"></i> ' . __('Back to Vendors'),
                ['action' => 'index'],
                ['class' => 'btn-back', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="bi bi-plus-lg"></i> ' . __('New Vendor'),
                ['action' => 'add'],
                ['class' => 'btn-new', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="bi bi-pencil-square"></i> ' . __('Edit Vendor'),
                ['action' => 'edit', $vendorEntity->vendor_id],
                ['class' => 'btn-edit', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="bi bi-trash"></i> ' . __('Delete Vendor'),
                ['action' => 'delete', $vendorEntity->vendor_id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $vendorEntity->vendor_id),
                    'class' => 'btn-delete',
                    'escape' => false,
                ]
            ) ?>
        </div>
    </div>

    <section class="view-card">
        <h2 class="view-card-title">
            <i class="bi bi-building"></i>
            <?= __('Vendor Details') ?>
        </h2>

        <div class="info-grid">
            <div class="info-box">
                <span class="info-label"><?= __('Vendor ID') ?></span>
                <span class="info-value"><?= $this->Number->format($vendorEntity->vendor_id) ?></span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Vendor Name') ?></span>
                <span class="info-value"><?= h($vendorEntity->vendor_name) ?></span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Contact Person') ?></span>
                <span class="info-value"><?= h($vendorEntity->contact_person ?: '-') ?></span>
            </div>

            <div class="info-box">
                <span class="info-label"><?= __('Phone Number') ?></span>
                <span class="info-value"><?= h($vendorEntity->phone_no ?: '-') ?></span>
            </div>

            <div class="info-box info-box-wide">
                <span class="info-label"><?= __('Email') ?></span>
                <span class="info-value"><?= h($vendorEntity->email ?: '-') ?></span>
            </div>
        </div>
    </section>

    <section class="view-card">
        <h2 class="view-card-title">
            <i class="bi bi-geo-alt"></i>
            <?= __('Address') ?>
        </h2>

        <div class="description-box">
            <?= $vendorEntity->address ? $this->Text->autoParagraph(h($vendorEntity->address)) : '<p>-</p>' ?>
        </div>
    </section>
</div>
