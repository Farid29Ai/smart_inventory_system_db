<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisitionEntity
 * @var string[]|\Cake\Collection\CollectionInterface $staffs
 * @var string[]|\Cake\Collection\CollectionInterface $admins
 * @var string[]|\Cake\Collection\CollectionInterface $item
 */
$currentUser = $currentUser ?? [];
$staffOptions = is_object($staffs) && method_exists($staffs, 'toArray') ? $staffs->toArray() : (array)$staffs;
$selectedStaffName = $staffOptions[$requisitionEntity->staff_id] ?? ($currentUser['name'] ?? 'Staff Member');
$selectedItemIds = [];
if (!empty($requisitionEntity->item)) {
    foreach ($requisitionEntity->item as $selectedItem) {
        $selectedItemIds[] = $selectedItem->item_id;
    }
}
$firstSelectedItemId = $selectedItemIds[0] ?? null;
$firstQuantity = !empty($requisitionEntity->item[0] ?? null)
    ? ($requisitionEntity->item[0]->_joinData->quantity_requested ?? 1)
    : 1;
?>
<div class="requisition form content requisition-create-page requisition-edit-page">
    <section class="requisition-create-shell">
        <div class="requisition-create-header">
            <div>
                <nav class="requisition-breadcrumb" aria-label="breadcrumb">
                    <?= $this->Html->link('My Requests', ['action' => 'index']) ?>
                    <span>/</span>
                    <strong>Edit Request</strong>
                </nav>
                <div class="requisition-title-row">
                    <span class="requisition-title-icon"><i class="bi bi-pencil-square"></i></span>
                    <div>
                        <h1>Edit Requisition</h1>
                        <p>Update your office supply requisition before it is processed.</p>
                    </div>
                </div>
            </div>
            <div class="requisition-action-row">
                <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to My Requests', ['action' => 'index'], ['class' => 'req-btn req-btn-outline', 'escape' => false]) ?>
                <?= $this->Form->create(null, [
                    'url' => ['controller' => 'Requisition', 'action' => 'delete', $requisitionEntity->requisition_id],
                    'class' => 'delete-request-inline-form',
                    'data-delete-request-form' => true,
                ]) ?>
                    <?= $this->Form->button('<i class="bi bi-trash"></i> Delete Request', [
                        'class' => 'req-btn req-btn-danger',
                        'data-delete-request-trigger' => true,
                        'escapeTitle' => false,
                    ]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="delete-request-modal" data-delete-request-modal aria-hidden="true">
            <div class="delete-request-dialog" role="dialog" aria-modal="true" aria-labelledby="deleteRequestTitle">
                <div class="delete-request-icon"><i class="bi bi-trash"></i></div>
                <h2 id="deleteRequestTitle">Delete Request?</h2>
                <p>Are you sure you want to delete this requisition? This action cannot be undone.</p>
                <div class="delete-request-actions">
                    <button type="button" class="req-btn req-btn-outline" data-delete-request-cancel>Cancel</button>
                    <button type="button" class="req-btn req-btn-danger" data-delete-request-confirm>
                        <i class="bi bi-trash"></i> Delete Request
                    </button>
                </div>
            </div>
        </div>

        <?= $this->Form->create($requisitionEntity) ?>
        <div class="requisition-form-card si-requisition-panel">
            <div class="requisition-form-grid si-form-grid">
                <section class="requisition-section-card si-form-card">
                    <h4 class="si-form-section-title"><i class="bi bi-person-badge"></i> Staff Information</h4>
                    <?= $this->Form->hidden('staff_id', ['value' => $requisitionEntity->staff_id]) ?>
                    <div class="readonly-field readonly-field-icon si-form-group">
                        <label class="si-form-label">Staff Name</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-person"></i></span>
                            <div class="si-readonly-field"><?= h($selectedStaffName) ?></div>
                        </div>
                    </div>
                    <div class="readonly-field readonly-field-icon si-form-group">
                        <label class="si-form-label">Department</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-building"></i></span>
                            <div class="si-readonly-field"><?= h($currentUser['department'] ?? '-') ?></div>
                        </div>
                    </div>
                    <div class="readonly-field readonly-field-icon si-form-group">
                        <label class="si-form-label">Position</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-briefcase"></i></span>
                            <div class="si-readonly-field"><?= h($currentUser['position'] ?? '-') ?></div>
                        </div>
                    </div>
                </section>

                <section class="requisition-section-card si-form-card">
                    <h4 class="si-form-section-title"><i class="bi bi-calendar2-check"></i> Request Information</h4>
                    <?= $this->Form->hidden('admin_id', ['value' => $requisitionEntity->admin_id]) ?>
                    <div class="req-icon-control si-form-group">
                        <label class="si-form-label">Request Date</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-calendar-event"></i></span>
                        <?= $this->Form->control('request_date', [
                            'empty' => true,
                            'label' => false,
                            'class' => 'form-control',
                        ]) ?>
                        </div>
                    </div>
                    <div class="req-icon-control si-form-group">
                        <label class="si-form-label">Required Date</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-calendar-check"></i></span>
                        <?= $this->Form->control('required_date', [
                            'empty' => true,
                            'label' => false,
                            'class' => 'form-control',
                        ]) ?>
                        </div>
                    </div>
                    <div class="req-icon-control si-form-group">
                        <label class="si-form-label">Priority</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-flag"></i></span>
                        <?= $this->Form->control('priority', [
                            'type' => 'select',
                            'options' => [
                                'Low' => 'Low',
                                'Normal' => 'Normal',
                                'High' => 'High',
                                'Urgent' => 'Urgent',
                            ],
                            'default' => $requisitionEntity->priority ?? 'Normal',
                            'label' => false,
                            'class' => 'form-select',
                        ]) ?>
                        </div>
                    </div>
                </section>
            </div>

            <section class="requisition-section-card requisition-span-card si-form-card si-full">
                <h4 class="si-form-section-title"><i class="bi bi-chat-square-text"></i> Purpose / Request Reason</h4>
                <div class="si-form-group si-full">
                <?= $this->Form->control('purpose', [
                    'type' => 'textarea',
                    'label' => false,
                    'placeholder' => 'Explain why these office supplies are required...',
                    'class' => 'form-control requisition-textarea-lg si-textarea',
                ]) ?>
                </div>
            </section>

            <section class="requisition-section-card requisition-span-card si-form-card si-full">
                <h4 class="si-form-section-title"><i class="bi bi-journal-text"></i> Remarks <span>Optional</span></h4>
                <div class="si-form-group si-full">
                <?= $this->Form->control('remarks', [
                    'type' => 'textarea',
                    'label' => false,
                    'placeholder' => 'Add any additional information or remarks...',
                    'class' => 'form-control si-textarea',
                ]) ?>
                </div>
            </section>

            <section class="requisition-section-card requisition-span-card si-form-card si-full">
                <div class="requested-items-head">
                    <h4 class="si-form-section-title"><i class="bi bi-box-seam"></i> Requested Items</h4>
                </div>
                <div class="requested-items-table-wrap">
                    <table class="requested-items-table edit-request-items-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Available Stock</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody data-request-items-body>
                            <tr>
                                <td data-label="Item" class="requested-item-select-cell">
                                    <?= $this->Form->control('item._ids', [
                                        'options' => $item,
                                        'default' => $firstSelectedItemId,
                                        'label' => false,
                                        'multiple' => false,
                                        'size' => 1,
                                        'name' => 'item[_ids][]',
                                        'class' => 'form-select',
                                    ]) ?>
                                </td>
                                <td data-label="Quantity" class="requested-qty-cell">
                                    <?= $this->Form->control('quantity_requested', [
                                        'type' => 'number',
                                        'min' => 1,
                                        'value' => $firstQuantity,
                                        'label' => false,
                                        'class' => 'form-control',
                                    ]) ?>
                                </td>
                                <td data-label="Available Stock"><span class="stock-chip"><i></i> Available</span></td>
                                <td data-label="Unit"><span class="unit-chip">Unit</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="requisition-form-actions">
                <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'req-btn req-btn-outline']) ?>
                <?= $this->Form->button('<i class="bi bi-check2-circle"></i> Save Changes', ['class' => 'req-btn req-btn-gradient', 'escapeTitle' => false]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForm = document.querySelector('[data-delete-request-form]');
    const modal = document.querySelector('[data-delete-request-modal]');
    if (!deleteForm || !modal) {
        return;
    }

    let confirmed = false;
    const cancelButton = modal.querySelector('[data-delete-request-cancel]');
    const confirmButton = modal.querySelector('[data-delete-request-confirm]');

    const closeModal = function () {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
    };

    deleteForm.addEventListener('submit', function (event) {
        if (confirmed) {
            return;
        }
        event.preventDefault();
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    });

    cancelButton?.addEventListener('click', closeModal);
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    confirmButton?.addEventListener('click', function () {
        confirmed = true;
        deleteForm.submit();
    });
});
</script>
