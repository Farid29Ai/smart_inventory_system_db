<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $itemEntity
 */
$stock = (int)($itemEntity->quantity_available ?? 0);
$minimum = (int)($itemEntity->minimum_stock ?? 0);
$statusLabel = $itemEntity->status ?: 'Available';
$statusClass = 'item-detail-status-available';
if ($stock <= 0) {
    $statusLabel = 'Out of Stock';
    $statusClass = 'item-detail-status-out';
} elseif ($stock <= $minimum) {
    $statusLabel = 'Low Stock';
    $statusClass = 'item-detail-status-low';
}
$formatDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format('d M Y, h:i A');
    }

    return h((string)$value);
};
$categoryName = $itemEntity->category->category_name ?? '-';
$vendorName = $itemEntity->vendor->vendor_name ?? '-';
?>
<div class="item view content item-detail-page">
    <div class="item-detail-shell">
        <div class="item-detail-top">
            <nav class="item-detail-breadcrumb" aria-label="breadcrumb">
                <?= $this->Html->link('Item Catalog', ['action' => 'index']) ?>
                <span>/</span>
                <strong>View Item</strong>
            </nav>
            <div class="item-detail-actions">
                <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to Item Catalog', ['action' => 'index'], ['class' => 'item-detail-btn item-detail-btn-outline', 'escape' => false]) ?>
            </div>
        </div>

        <div class="item-detail-grid">
            <section class="item-detail-product-card">
                <div class="item-detail-image-frame">
                    <?php if (!empty($itemEntity->item_image)): ?>
                        <?= $this->Html->image($itemEntity->item_image, ['alt' => $itemEntity->item_name]) ?>
                    <?php else: ?>
                        <div class="item-detail-empty-image">
                            <i class="bi bi-image"></i>
                            <span>No image uploaded</span>
                        </div>
                    <?php endif; ?>
                </div>

                <h2><?= h($itemEntity->item_name) ?></h2>
                <span class="item-detail-status <?= h($statusClass) ?>"><i></i><?= h($statusLabel) ?></span>

                <div class="item-detail-mini-grid">
                    <div class="item-detail-mini-card">
                        <i class="bi bi-box-seam"></i>
                        <span>Category</span>
                        <strong><?= h($categoryName) ?></strong>
                    </div>
                    <div class="item-detail-mini-card purple">
                        <i class="bi bi-person-badge"></i>
                        <span>Vendor</span>
                        <strong><?= h($vendorName) ?></strong>
                    </div>
                </div>

                <div class="item-detail-stock-panel">
                    <div>
                        <i class="bi bi-boxes"></i>
                        <span>Quantity Available</span>
                        <strong><?= $this->Number->format($stock) ?></strong>
                        <small><?= h($itemEntity->unit ?: 'unit') ?></small>
                    </div>
                    <div>
                        <i class="bi bi-stack"></i>
                        <span>Minimum Stock</span>
                        <strong><?= $this->Number->format($minimum) ?></strong>
                        <small><?= h($itemEntity->unit ?: 'unit') ?></small>
                    </div>
                </div>

                <?php if (!empty($itemEntity->description)): ?>
                    <div class="item-detail-description">
                        <span>Description</span>
                        <p><?= h($itemEntity->description) ?></p>
                    </div>
                <?php endif; ?>
            </section>

            <section class="item-detail-info-card">
                <h3><i class="bi bi-list-check"></i> Item Details</h3>
                <div class="item-detail-table">
                    <div>
                        <span>Item Catalog Name</span>
                        <strong><?= h($itemEntity->item_name) ?></strong>
                    </div>
                    <div>
                        <span>Category</span>
                        <strong><?= $itemEntity->hasValue('category') ? $this->Html->link($categoryName, ['controller' => 'Category', 'action' => 'view', $itemEntity->category->category_id]) : h($categoryName) ?></strong>
                    </div>
                    <div>
                        <span>Vendor</span>
                        <strong><?= $itemEntity->hasValue('vendor') ? $this->Html->link($vendorName, ['controller' => 'Vendor', 'action' => 'view', $itemEntity->vendor->vendor_id]) : h($vendorName) ?></strong>
                    </div>
                    <div>
                        <span>Quantity Available</span>
                        <strong><?= $this->Number->format($stock) ?> <?= h($itemEntity->unit ?: '') ?></strong>
                    </div>
                    <div>
                        <span>Minimum Stock</span>
                        <strong><?= $this->Number->format($minimum) ?> <?= h($itemEntity->unit ?: '') ?></strong>
                    </div>
                    <div>
                        <span>Unit</span>
                        <strong><?= h($itemEntity->unit ?: '-') ?></strong>
                    </div>
                    <div>
                        <span>Status</span>
                        <strong><span class="item-detail-status <?= h($statusClass) ?>"><i></i><?= h($statusLabel) ?></span></strong>
                    </div>
                    <div>
                        <span>Created At</span>
                        <strong><i class="bi bi-calendar3"></i> <?= $formatDate($itemEntity->created_at) ?></strong>
                    </div>
                    <div>
                        <span>Updated At</span>
                        <strong><i class="bi bi-calendar3"></i> <?= $formatDate($itemEntity->updated_at) ?></strong>
                    </div>
                </div>
            </section>
        </div>

    </div>
</div>
