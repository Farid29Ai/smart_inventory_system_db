<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Requisition> $requisition
 */
$isStaffRequests = ($currentRole ?? null) === 'staff';
$formatRequestDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format('d M Y');
    }

    return h((string)$value);
};
?>
<div class="requisition index content <?= $isStaffRequests ? 'staff-my-requests-page' : 'admin-crud-page' ?>">
    <?php if ($isStaffRequests): ?>
        <div class="staff-requests-header">
            <div>
                <h1>My Requests</h1>
                <p>View and track your office supply requisition status.</p>
            </div>
            <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Requisition', ['action' => 'add'], ['class' => 'staff-request-new-btn', 'escape' => false]) ?>
        </div>
    <?php else: ?>
        <div class="admin-crud-header">
            <div>
                <h1>Requisition Management</h1>
                <p>Manage staff requisitions, approvals and request status.</p>
            </div>
            <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Requisition', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
        </div>
    <?php endif; ?>
    <div class="table-responsive <?= $isStaffRequests ? 'table-scroll-wrapper staff-requests-card' : 'table-scroll-wrapper admin-crud-table-card' ?>">
        <table class="<?= $isStaffRequests ? 'staff-requests-table my-requests-table' : 'table admin-table' ?>">
            <?php if (!$isStaffRequests): ?>
                <colgroup>
                    <col style="width:140px">
                    <col style="width:190px">
                    <col style="width:220px">
                    <col style="width:150px">
                    <col style="width:150px">
                    <col style="width:170px">
                    <col style="width:130px">
                </colgroup>
            <?php else: ?>
                <colgroup>
                    <col style="width:120px">
                    <col style="width:140px">
                    <col style="width:170px">
                    <col style="width:170px">
                    <col style="width:130px">
                    <col style="width:160px">
                    <col style="width:170px">
                </colgroup>
            <?php endif; ?>
            <thead>
                <tr>
                    <th class="<?= $isStaffRequests ? 'requisition-id-column' : '' ?>"><?= $this->Paginator->sort('requisition_id', 'Requisition ID') ?></th>
                    <?php if ($isStaffRequests): ?>
                        <th><?= __('Item Image') ?></th>
                    <?php else: ?>
                        <th><?= $this->Paginator->sort('staff_id', 'Staff') ?></th>
                        <th><?= $this->Paginator->sort('admin_id', 'Admin') ?></th>
                    <?php endif; ?>
                    <th><?= $this->Paginator->sort('request_date', 'Request Date') ?></th>
                    <th><?= $this->Paginator->sort('required_date', 'Required Date') ?></th>
                    <?php if ($isStaffRequests): ?>
                        <th><?= __('Total Items') ?></th>
                    <?php endif; ?>
                    <th class="<?= $isStaffRequests ? 'status-cell' : 'status-cell' ?>"><?= $this->Paginator->sort('status', 'Status') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisition as $requisitionEntity): ?>
                <?php
                    $requestedItems = (array)($requisitionEntity->item ?? []);
                    $totalItems = count($requestedItems);
                    $firstItem = $requestedItems[0] ?? null;
                    $firstItemName = $firstItem->item_name ?? __('Requested item');
                    $extraItems = max(0, $totalItems - 1);
                    $imageTitle = $extraItems > 0
                        ? __("{0} and {1} more item(s)", $firstItemName, $extraItems)
                        : (string)$firstItemName;
                ?>
                <tr>
                    <td class="<?= $isStaffRequests ? 'requisition-id-cell' : 'req-id-cell' ?>"><?= $this->Number->format($requisitionEntity->requisition_id) ?></td>
                    <?php if ($isStaffRequests): ?>
                        <td class="request-item-image-cell">
                            <span class="item-image-stack" title="<?= h($imageTitle) ?>">
                                <?php if ($firstItem && !empty($firstItem->item_image)): ?>
                                    <?= $this->Html->image($firstItem->item_image, ['class' => 'request-item-image', 'alt' => $firstItemName]) ?>
                                <?php else: ?>
                                    <span class="item-placeholder"><i class="bi bi-box-seam"></i></span>
                                <?php endif; ?>
                                <?php if ($extraItems > 0): ?>
                                    <span class="item-count-badge">+<?= $this->Number->format($extraItems) ?></span>
                                <?php endif; ?>
                            </span>
                        </td>
                    <?php else: ?>
                        <td class="staff-cell"><?= $requisitionEntity->hasValue('staff') ? $this->Html->link($requisitionEntity->staff->staff_name, ['controller' => 'Staff', 'action' => 'view', $requisitionEntity->staff->staff_id]) : '' ?></td>
                        <td class="admin-cell"><?= $requisitionEntity->hasValue('admin') ? $this->Html->link($requisitionEntity->admin->admin_name, ['controller' => 'Admin', 'action' => 'view', $requisitionEntity->admin->admin_id]) : '' ?></td>
                    <?php endif; ?>
                    <td class="<?= $isStaffRequests ? '' : 'request-date-cell' ?>"><?= $formatRequestDate($requisitionEntity->request_date) ?></td>
                    <td class="<?= $isStaffRequests ? '' : 'required-date-cell' ?>"><?= $formatRequestDate($requisitionEntity->required_date) ?></td>
                    <?php if ($isStaffRequests): ?>
                        <td class="request-total-items">
                            <strong><?= $this->Number->format($totalItems) ?></strong>
                            <span><?= __n('item', 'items', $totalItems) ?></span>
                        </td>
                    <?php endif; ?>
                    <?php $status = strtolower((string)($requisitionEntity->status ?: 'pending')); ?>
                    <?php $isPending = $status === 'pending'; ?>
                    <td class="status-cell"><span class="status-badge status-<?= h($status) ?>"><?= h($requisitionEntity->status ?: 'Pending') ?></span></td>
                    <td class="actions-cell <?= $isStaffRequests ? 'staff-request-actions' : '' ?>">
                        <?php if ($isStaffRequests): ?>
                            <div class="request-action-group">
                                <?= $this->Html->link('<i class="bi bi-eye"></i><span>View</span>', ['action' => 'view', $requisitionEntity->requisition_id], ['class' => 'request-action-btn view-btn', 'escape' => false]) ?>
                            </div>
                        <?php else: ?>
                            <div class="action-group action-buttons">
                                <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $requisitionEntity->requisition_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator <?= $isStaffRequests ? 'staff-requests-pagination' : '' ?>">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
