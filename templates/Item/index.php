<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Item> $item
 * @var array<int, string> $categories
 * @var string $keyword
 * @var string|int|null $categoryId
 */
$categories = $categories ?? [];
$keyword = $keyword ?? (string)$this->request->getQuery('keyword', '');
$categoryId = $categoryId ?? $this->request->getQuery('category_id');
$isStaffCatalog = (($currentRole ?? null) === 'staff');
$filterQuery = array_filter([
    'keyword' => $keyword,
    'category_id' => $categoryId,
], static fn($value) => $value !== null && $value !== '');
$this->Paginator->options(['url' => ['?' => $filterQuery]]);
$categoryMeta = function (?string $categoryName): array {
    $name = strtolower((string)$categoryName);
    if (str_contains($name, 'it') || str_contains($name, 'electronic') || str_contains($name, 'computer')) {
        return ['bi-laptop', 'catalog-category-blue'];
    }
    if (str_contains($name, 'office') || str_contains($name, 'supply')) {
        return ['bi-pen', 'catalog-category-purple'];
    }
    if (str_contains($name, 'station')) {
        return ['bi-pencil-square', 'catalog-category-cyan'];
    }

    return ['bi-box-seam', 'catalog-category-green'];
};
$formatDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format('d M Y') . '<span>' . $value->format('h:i A') . '</span>';
    }

    return h((string)$value);
};
?>
<div class="item index content item-catalog-dashboard <?= ($currentRole ?? null) === 'admin' ? 'item-admin-catalog' : '' ?>">
    <section class="catalog-card">
        <div class="catalog-header">
            <div>
                <span class="catalog-kicker">Inventory Workspace</span>
                <h3><?= __('Item Catalog') ?></h3>
                <p>Browse available inventory items that can be requested by staff.</p>
            </div>
            <?php if ($isStaffCatalog): ?>
                <?= $this->Html->link('<i class="bi bi-plus-lg"></i> Request Item', ['controller' => 'Requisition', 'action' => 'add'], ['class' => 'catalog-gradient-btn catalog-header-request-btn', 'escape' => false]) ?>
            <?php endif; ?>
        </div>

        <?php if ($isStaffCatalog): ?>
            <section class="catalog-filter-card">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'catalog-filter-form']) ?>
                    <div class="catalog-filter-grid">
                        <div class="catalog-filter-field catalog-search-field">
                            <label for="catalog-keyword">Search Item</label>
                            <div class="catalog-filter-control">
                                <i class="bi bi-search"></i>
                                <input
                                    id="catalog-keyword"
                                    type="text"
                                    name="keyword"
                                    value="<?= h($keyword) ?>"
                                    placeholder="Search item name or category..."
                                >
                            </div>
                        </div>
                        <div class="catalog-filter-field">
                            <label for="catalog-category">Category</label>
                            <div class="catalog-filter-control catalog-filter-select">
                                <select id="catalog-category" name="category_id">
                                    <option value=""><?= __('All Categories') ?></option>
                                    <?php foreach ($categories as $id => $name): ?>
                                        <option value="<?= h((string)$id) ?>" <?= (string)$categoryId === (string)$id ? 'selected' : '' ?>>
                                            <?= h($name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="bi bi-chevron-down"></i>
                            </div>
                        </div>
                        <button class="catalog-filter-submit" type="submit">
                            <i class="bi bi-search"></i>
                            <span><?= __('Search') ?></span>
                        </button>
                        <?= $this->Html->link('<i class="bi bi-arrow-counterclockwise"></i><span>Reset</span>', ['action' => 'index'], ['class' => 'catalog-filter-reset', 'escape' => false]) ?>
                    </div>
                <?= $this->Form->end() ?>

                <div class="catalog-filter-chips" aria-label="Category shortcuts">
                    <?= $this->Html->link(__('All Categories'), ['action' => 'index', '?' => $keyword !== '' ? ['keyword' => $keyword] : []], ['class' => 'catalog-filter-chip ' . ((string)$categoryId === '' ? 'active' : '')]) ?>
                    <?php foreach ($categories as $id => $name): ?>
                        <?php
                            $chipQuery = ['category_id' => $id];
                            if ($keyword !== '') {
                                $chipQuery['keyword'] = $keyword;
                            }
                        ?>
                        <?= $this->Html->link(h($name), ['action' => 'index', '?' => $chipQuery], ['class' => 'catalog-filter-chip ' . ((string)$categoryId === (string)$id ? 'active' : ''), 'escape' => false]) ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <div class="catalog-toolbar catalog-toolbar-minimal">
            <label class="catalog-entries-control">
                <span>Show</span>
                <select aria-label="Show entries">
                    <?php if (($currentRole ?? null) === 'admin'): ?>
                        <option selected>12</option>
                        <option>24</option>
                        <option>36</option>
                    <?php else: ?>
                        <option selected>10</option>
                        <option>25</option>
                        <option>50</option>
                    <?php endif; ?>
                </select>
                <span>entries</span>
            </label>
            <?php if (($currentRole ?? null) === 'admin'): ?>
                <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Item Catalog', ['action' => 'add'], ['class' => 'catalog-gradient-btn', 'escape' => false]) ?>
            <?php endif; ?>
        </div>

        <div class="table-responsive catalog-table-wrap <?= ($currentRole ?? null) === 'admin' ? 'table-scroll-wrapper' : '' ?>">
            <table class="catalog-table table admin-table">
                <?php if (($currentRole ?? null) === 'admin'): ?>
                    <colgroup>
                        <col style="width:190px">
                        <col style="width:210px">
                        <col style="width:120px">
                        <col style="width:100px">
                        <col style="width:120px">
                        <col style="width:160px">
                        <col style="width:180px">
                    </colgroup>
                <?php elseif ($isStaffCatalog): ?>
                    <colgroup>
                        <col style="width:300px">
                        <col style="width:150px">
                        <col style="width:120px">
                        <col style="width:140px">
                        <col style="width:160px">
                        <col style="width:140px">
                    </colgroup>
                <?php endif; ?>
                <thead>
                    <tr>
                        <?php if ($isStaffCatalog): ?>
                            <th class="item-name-cell"><?= $this->Paginator->sort('item_name', 'Item Name') ?></th>
                        <?php else: ?>
                            <th class="category-cell"><?= $this->Paginator->sort('category_id', 'Category') ?></th>
                            <th class="vendor-cell admin-item-name-column"><?= $this->Paginator->sort('item_name', 'Item Name') ?></th>
                        <?php endif; ?>
                        <th class="stock-cell"><?= $this->Paginator->sort('quantity_available', 'Stock') ?></th>
                        <th class="unit-cell"><?= $this->Paginator->sort('unit', 'Unit') ?></th>
                        <th class="image-cell"><?= $this->Paginator->sort('item_image', 'Image') ?></th>
                        <th class="status-cell"><?= $this->Paginator->sort('status', 'Status') ?></th>
                        <th class="actions actions-column"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $hasItems = false; ?>
                    <?php foreach ($item as $itemEntity): ?>
                        <?php
                        $hasItems = true;
                        $categoryName = $itemEntity->category->category_name ?? 'Uncategorized';
                        [$categoryIcon, $categoryClass] = $categoryMeta($categoryName);
                        $vendorName = (string)($itemEntity->vendor->vendor_name ?? 'Unassigned Vendor');
                        $stock = (int)($itemEntity->quantity_available ?? 0);
                        $minimum = (int)($itemEntity->minimum_stock ?? 0);
                        $imagePath = trim((string)($itemEntity->item_image ?? ''));
                        $imageExists = false;
                        if ($imagePath !== '') {
                            $normalizedImagePath = str_replace(['/', '\\'], DS, ltrim($imagePath, '/\\'));
                            $imageExists = is_file(WWW_ROOT . $normalizedImagePath)
                                || is_file(WWW_ROOT . 'img' . DS . $normalizedImagePath);
                        }
                        if (!$imageExists) {
                            $imagePath = 'items/default-item.png';
                        }
                        $statusClass = 'catalog-status-available';
                        $statusLabel = $itemEntity->status ?: 'Available';
                        if ($stock <= 0) {
                            $statusClass = 'catalog-status-out';
                            $statusLabel = 'Out of Stock';
                        } elseif ($stock <= $minimum) {
                            $statusClass = 'catalog-status-low';
                            $statusLabel = 'Low Stock';
                        }
                        ?>
                        <tr data-search="<?= h($itemEntity->item_name . ' ' . $categoryName . ' ' . $vendorName . ' ' . $itemEntity->unit . ' ' . $statusLabel) ?>">
                            <?php if ($isStaffCatalog): ?>
                                <td class="item-name-cell">
                                    <div class="staff-catalog-item">
                                        <span class="staff-item-icon <?= h($categoryClass) ?>">
                                            <i class="bi <?= h($categoryIcon) ?>"></i>
                                        </span>
                                        <span class="staff-item-copy">
                                            <?= $this->Html->link(h($itemEntity->item_name), ['action' => 'view', $itemEntity->item_id], ['class' => 'staff-item-name', 'escape' => false]) ?>
                                            <span class="staff-category-badge"><?= h($categoryName) ?></span>
                                        </span>
                                    </div>
                                </td>
                            <?php else: ?>
                                <td class="category-cell">
                                    <div class="catalog-category-pill category-content <?= h($categoryClass) ?>">
                                        <i class="bi <?= h($categoryIcon) ?> category-icon"></i>
                                        <span class="category-name">
                                            <?= $itemEntity->hasValue('category') ? $this->Html->link($categoryName, ['controller' => 'Category', 'action' => 'view', $itemEntity->category->category_id]) : h($categoryName) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="vendor-cell admin-item-name-column">
                                    <div class="catalog-vendor catalog-admin-item-name">
                                        <?= $this->Html->link(h($itemEntity->item_name), ['action' => 'view', $itemEntity->item_id], ['escape' => false]) ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <td class="stock-cell">
                                <div class="catalog-stock">
                                    <strong><?= $this->Number->format($stock) ?></strong>
                                    <span>available</span>
                                </div>
                            </td>
                            <td class="unit-cell"><span class="catalog-unit"><?= h($itemEntity->unit ?: '-') ?></span></td>
                            <td class="image-cell">
                                <div class="catalog-image-box">
                                    <?= $this->Html->image($imagePath, ['alt' => $itemEntity->item_name, 'class' => 'catalog-item-image']) ?>
                                </div>
                            </td>
                            <td class="status-cell"><span class="catalog-status status-badge <?= h($statusClass) ?>"><i></i><?= h($statusLabel) ?></span></td>
                            <td class="actions catalog-actions actions-cell">
                                <?php if (($currentRole ?? null) === 'admin'): ?>
                                    <div class="action-group">
                                        <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $itemEntity->item_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $itemEntity->item_id], ['class' => 'action-icon-btn action-edit edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                                        <?= $this->Form->postButton(
                                            '<i class="bi bi-trash"></i>',
                                            ['action' => 'delete', $itemEntity->item_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete # {0}?', $itemEntity->item_id),
                                                'class' => 'action-icon-btn action-delete delete-btn',
                                                'aria-label' => __('Delete'),
                                                'title' => __('Delete'),
                                                'escapeTitle' => false,
                                            ]
                                        ) ?>
                                    </div>
                                <?php elseif (($currentRole ?? null) === 'staff'): ?>
                                    <div class="staff-item-actions">
                                        <?= $this->Html->link('<i class="bi bi-eye"></i> View', ['action' => 'view', $itemEntity->item_id], ['class' => 'catalog-view-btn btn-view', 'escape' => false]) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$hasItems): ?>
                        <tr>
                            <td colspan="<?= $isStaffCatalog ? 6 : 7 ?>">
                                <div class="catalog-empty-state">
                                    <i class="bi bi-search"></i>
                                    <h4><?= __('No items found') ?></h4>
                                    <p><?= __('Try another keyword or choose a different category.') ?></p>
                                    <?= $this->Html->link(__('Reset Filter'), ['action' => 'index'], ['class' => 'catalog-filter-reset catalog-empty-reset']) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="catalog-pagination">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </section>
</div>
