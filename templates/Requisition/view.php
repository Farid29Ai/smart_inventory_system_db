<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisitionEntity
 */
$status = strtolower((string)($requisitionEntity->status ?? 'pending'));
$statusLabel = $requisitionEntity->status ?: 'Pending';
$priority = $requisitionEntity->priority ?? 'Normal';
$approvalDate = $requisitionEntity->approval_date ?? $requisitionEntity->approved_at ?? null;
$staff = $requisitionEntity->staff ?? null;
$admin = $requisitionEntity->admin ?? null;
$isAdmin = (($currentRole ?? $this->request->getSession()->read('Auth.Role')) === 'admin');
$isStaff = !$isAdmin;
$isPending = $status === 'pending';
$listLabel = $isAdmin ? 'Requisition' : 'My Requests';
$backLabel = $isAdmin ? 'Back to Requisition List' : 'Back to My Requests';
$subtitle = $isAdmin ? 'Review staff requisition information before approval.' : 'Review your office supply request information and current status.';
$formatDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return h($value->format('d M Y'));
    }

    return h((string)$value);
};
?>
<div class="requisition view content staff-request-view-page">
    <div class="request-view-header">
        <div>
            <nav class="request-view-breadcrumb" aria-label="Breadcrumb">
                <?= $this->Html->link($listLabel, ['action' => 'index']) ?>
                <span>/</span>
                <strong>View Request</strong>
            </nav>
            <h1>Request Details</h1>
            <p><?= h($subtitle) ?></p>
        </div>
        <div class="request-view-actions">
            <?= $this->Html->link('<i class="bi bi-arrow-left"></i> ' . $backLabel, ['action' => 'index'], ['class' => 'request-view-back-btn', 'escape' => false]) ?>
            <?php if ($isStaff && $isPending): ?>
                <?= $this->Html->link('<i class="bi bi-pencil"></i> Edit Request', ['action' => 'edit', $requisitionEntity->requisition_id], ['class' => 'request-view-edit-btn', 'escape' => false]) ?>
                <?= $this->Form->postLink(
                    '<i class="bi bi-trash"></i> Delete Request',
                    ['controller' => 'Requisition', 'action' => 'delete', $requisitionEntity->requisition_id],
                    [
                        'confirm' => __('Are you sure you want to delete this request?'),
                        'class' => 'request-view-delete-btn',
                        'escapeTitle' => false,
                    ]
                ) ?>
            <?php endif; ?>
            <?php if ($isAdmin && $isPending): ?>
                <?= $this->Form->create(null, [
                    'url' => ['action' => 'approve', $requisitionEntity->requisition_id],
                    'class' => 'request-approval-form',
                    'data-approval-form' => 'approve',
                ]) ?>
                    <?= $this->Form->button('<i class="bi bi-check2-circle"></i> Approve Request', [
                        'class' => 'request-approve-btn',
                        'type' => 'submit',
                        'escapeTitle' => false,
                    ]) ?>
                <?= $this->Form->end() ?>
                <?= $this->Form->create(null, [
                    'url' => ['action' => 'reject', $requisitionEntity->requisition_id],
                    'class' => 'request-approval-form',
                    'data-approval-form' => 'reject',
                ]) ?>
                    <?= $this->Form->button('<i class="bi bi-x-circle"></i> Reject Request', [
                        'class' => 'request-reject-btn',
                        'type' => 'submit',
                        'escapeTitle' => false,
                    ]) ?>
                <?= $this->Form->end() ?>
            <?php elseif ($isAdmin): ?>
                <span class="request-approval-state request-approval-state-<?= h($status) ?>">
                    <i class="bi bi-<?= $status === 'approved' ? 'check2-circle' : 'x-circle' ?>"></i>
                    <?= h($statusLabel) ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($isAdmin && $isPending): ?>
        <div class="approval-confirm-modal" data-approval-modal aria-hidden="true">
            <div class="approval-confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="approvalConfirmTitle">
                <div class="approval-confirm-icon" data-approval-icon><i class="bi bi-check2-circle"></i></div>
                <h2 id="approvalConfirmTitle" data-approval-title>Approve Request?</h2>
                <p data-approval-message>Are you sure you want to approve this requisition?</p>
                <div class="approval-confirm-actions">
                    <button type="button" class="approval-cancel-btn" data-approval-cancel>Cancel</button>
                    <button type="button" class="approval-submit-btn" data-approval-confirm>Approve Request</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <section class="request-summary-grid" aria-label="Request summary">
        <article class="request-summary-card">
            <span>Request ID</span>
            <strong>#<?= $this->Number->format($requisitionEntity->requisition_id) ?></strong>
        </article>
        <article class="request-summary-card">
            <span>Status</span>
            <strong><span class="request-status-pill status-<?= h($status) ?>"><i></i><?= h($statusLabel) ?></span></strong>
        </article>
        <article class="request-summary-card">
            <span>Priority</span>
            <strong><?= h($priority) ?></strong>
        </article>
        <article class="request-summary-card">
            <span>Request Date</span>
            <strong><?= $formatDate($requisitionEntity->request_date) ?></strong>
        </article>
        <article class="request-summary-card">
            <span>Required Date</span>
            <strong><?= $formatDate($requisitionEntity->required_date) ?></strong>
        </article>
    </section>

    <section class="request-info-grid">
        <article class="request-info-card">
            <div class="request-card-title">
                <i class="bi bi-person-badge"></i>
                <h2>Staff Information</h2>
            </div>
            <div class="request-info-list">
                <div><span>Staff Name</span><strong><?= h($staff->staff_name ?? '-') ?></strong></div>
                <div><span>Department</span><strong><?= h($staff->department ?? '-') ?></strong></div>
                <div><span>Position</span><strong><?= h($staff->position ?? '-') ?></strong></div>
            </div>
        </article>

        <article class="request-info-card">
            <div class="request-card-title">
                <i class="bi bi-shield-check"></i>
                <h2>Admin Information</h2>
            </div>
            <div class="request-info-list">
                <div><span>Admin Name</span><strong><?= h($admin->admin_name ?? '-') ?></strong></div>
                <div><span>Approved By</span><strong><?= h($admin->admin_name ?? '-') ?></strong></div>
                <div><span>Approval Date</span><strong><?= $formatDate($approvalDate) ?></strong></div>
            </div>
        </article>
    </section>

    <section class="request-text-card">
        <div class="request-card-title">
            <i class="bi bi-card-text"></i>
            <h2>Purpose / Request Reason</h2>
        </div>
        <textarea readonly><?= h($requisitionEntity->purpose ?: '-') ?></textarea>
    </section>

    <section class="request-text-card">
        <div class="request-card-title">
            <i class="bi bi-chat-square-text"></i>
            <h2>Remarks</h2>
        </div>
        <textarea readonly><?= h($requisitionEntity->remarks ?: '-') ?></textarea>
    </section>

    <?php if (!empty($requisitionEntity->item)) : ?>
        <section class="request-items-card">
            <div class="request-card-title">
                <i class="bi bi-box-seam"></i>
                <h2>Requested Items</h2>
            </div>
            <div class="request-items-table-wrap">
                <table class="request-items-table">
                    <thead>
                        <tr>
                            <?php if ($isStaff): ?>
                                <th>Item Image</th>
                                <th>Item Name</th>
                            <?php else: ?>
                                <th>Item</th>
                            <?php endif; ?>
                            <th>Quantity Requested</th>
                            <?php if ($isAdmin): ?>
                                <th>Quantity Approved</th>
                            <?php endif; ?>
                            <th>Unit</th>
                            <th>Available Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requisitionEntity->item as $item) : ?>
                            <?php
                                $quantity = $item->_joinData->quantity_requested ?? '-';
                                $approvedQuantity = $item->_joinData->quantity_approved ?? '-';
                                $itemStatus = strtolower((string)($item->status ?? 'available'));
                                $itemStatusClass = str_replace([' ', '_'], '-', $itemStatus);
                            ?>
                            <tr>
                                <?php if ($isStaff): ?>
                                    <td>
                                        <div class="request-view-item-image">
                                            <?php if (!empty($item->item_image)): ?>
                                                <?= $this->Html->image($item->item_image, ['alt' => $item->item_name ?? __('Requested item')]) ?>
                                            <?php else: ?>
                                                <i class="bi bi-box-seam"></i>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="request-view-item-title"><?= h($item->item_name ?? '-') ?></strong>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <div class="request-item-name">
                                            <span><i class="bi bi-box"></i></span>
                                            <strong><?= h($item->item_name ?? '-') ?></strong>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td><?= h($quantity) ?></td>
                                <?php if ($isAdmin): ?>
                                    <td><?= h($approvedQuantity) ?></td>
                                <?php endif; ?>
                                <td><span class="request-unit-pill"><?= h($item->unit ?: '-') ?></span></td>
                                <td><?= h($item->quantity_available ?? '-') ?></td>
                                <td><span class="request-status-pill item-status-<?= h($itemStatusClass) ?>"><i></i><?= h($item->status ?: 'Available') ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>
</div>
<?php if ($isAdmin && $isPending): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('[data-approval-modal]');
    const forms = document.querySelectorAll('[data-approval-form]');
    if (!modal || !forms.length) {
        return;
    }

    let activeForm = null;
    const icon = modal.querySelector('[data-approval-icon]');
    const title = modal.querySelector('[data-approval-title]');
    const message = modal.querySelector('[data-approval-message]');
    const cancelButton = modal.querySelector('[data-approval-cancel]');
    const confirmButton = modal.querySelector('[data-approval-confirm]');

    const content = {
        approve: {
            icon: '<i class="bi bi-check2-circle"></i>',
            title: 'Approve Request?',
            message: 'Are you sure you want to approve this requisition?',
            button: 'Approve Request',
            mode: 'approve',
        },
        reject: {
            icon: '<i class="bi bi-x-circle"></i>',
            title: 'Reject Request?',
            message: 'Are you sure you want to reject this requisition?',
            button: 'Reject Request',
            mode: 'reject',
        },
    };

    const closeModal = function () {
        modal.classList.remove('is-open', 'is-approve', 'is-reject');
        modal.setAttribute('aria-hidden', 'true');
        activeForm = null;
    };

    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const type = form.getAttribute('data-approval-form') || 'approve';
            const copy = content[type] || content.approve;
            event.preventDefault();
            activeForm = form;
            icon.innerHTML = copy.icon;
            title.textContent = copy.title;
            message.textContent = copy.message;
            confirmButton.textContent = copy.button;
            modal.classList.add('is-open', 'is-' + copy.mode);
            modal.setAttribute('aria-hidden', 'false');
        });
    });

    cancelButton?.addEventListener('click', closeModal);
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    confirmButton?.addEventListener('click', function () {
        if (activeForm) {
            activeForm.submit();
        }
    });
});
</script>
<?php endif; ?>
