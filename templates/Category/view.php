<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $categoryEntity
 */
$description = trim((string)($categoryEntity->description ?? ''));
?>
<section class="category-view-page view-page-container">
    <div class="view-header">
        <div>
            <nav class="view-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link(__('Admin'), ['controller' => 'Admin', 'action' => 'index']) ?>
                <span>/</span>
                <?= $this->Html->link(__('Category'), ['action' => 'index']) ?>
                <span>/</span>
                <strong><?= __('View Category') ?></strong>
            </nav>
            <h1 class="view-title"><?= __('Category Details') ?></h1>
            <p class="view-subtitle"><?= __('View category information and related description.') ?></p>
        </div>

        <div class="view-actions">
            <?= $this->Html->link(
                '<i class="bi bi-arrow-left"></i> ' . __('Back to Category List'),
                ['action' => 'index'],
                ['class' => 'btn-back', 'escape' => false]
            ) ?>
            <?= $this->Html->link(
                '<i class="bi bi-pencil-square"></i> ' . __('Edit Category'),
                ['action' => 'edit', $categoryEntity->category_id],
                ['class' => 'btn-edit', 'escape' => false]
            ) ?>
            <?= $this->Form->postLink(
                '<i class="bi bi-trash3"></i> ' . __('Delete Category'),
                ['action' => 'delete', $categoryEntity->category_id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $categoryEntity->category_id),
                    'class' => 'btn-delete',
                    'escape' => false,
                ]
            ) ?>
        </div>
    </div>

    <article class="view-card">
        <h2 class="view-card-title">
            <i class="bi bi-tags"></i>
            <?= __('Category Information') ?>
        </h2>
        <div class="info-grid">
            <div class="info-box">
                <div class="info-label"><?= __('Category Name') ?></div>
                <div class="info-value"><?= h($categoryEntity->category_name) ?></div>
            </div>
            <div class="info-box">
                <div class="info-label"><?= __('Category ID') ?></div>
                <div class="info-value"><?= $this->Number->format($categoryEntity->category_id) ?></div>
            </div>
        </div>
    </article>

    <article class="view-card">
        <h2 class="view-card-title">
            <i class="bi bi-card-text"></i>
            <?= __('Description') ?>
        </h2>
        <div class="description-box">
            <?= $description !== ''
                ? $this->Text->autoParagraph(h($description))
                : h(__('No description provided.')) ?>
        </div>
    </article>
</section>
