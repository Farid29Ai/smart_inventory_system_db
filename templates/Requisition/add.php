<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requisition $requisitionEntity
 * @var \Cake\Collection\CollectionInterface|string[] $staffs
 * @var \Cake\Collection\CollectionInterface|string[] $admins
 * @var \Cake\Collection\CollectionInterface|string[] $item
 * @var array<int> $selectedItemIds
 */
$staffName = $currentUser['name'] ?? 'Current Staff';
$staffDepartment = $currentUser['department'] ?? 'Auto filled from profile';
$staffPosition = $currentUser['position'] ?? 'Auto filled from profile';
$isStaff = ($currentRole ?? null) === 'staff';
?>
<div class="requisition form content requisition-create-page">
    <section class="requisition-create-shell">
        <div class="requisition-create-header">
            <div>
                <nav class="requisition-breadcrumb" aria-label="breadcrumb">
                    <?= $this->Html->link('Request Items', ['controller' => 'RequisitionItem', 'action' => 'index']) ?>
                    <span>/</span>
                    <strong>Create Requisition</strong>
                </nav>
                <h3><?= __('Office Supply Requisition') ?></h3>
                <p>Create a new office supply request for approval.</p>
            </div>
            <div class="requisition-action-row">
                <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to My Requests', ['action' => 'index'], ['class' => 'req-btn req-btn-outline', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="bi bi-clipboard-data"></i> View My Requests', ['action' => 'index'], ['class' => 'req-btn req-btn-soft', 'escape' => false]) ?>
            </div>
        </div>

        <?= $this->Form->create($requisitionEntity, ['class' => 'requisition-modern-form']) ?>
        <?php
            if ($isStaff) {
                echo $this->Form->hidden('staff_id', ['value' => $currentUser['id'] ?? null]);
            }
            echo $this->Form->hidden('admin_id');
            echo $this->Form->hidden('status', ['value' => $requisitionEntity->status ?: 'Pending']);
        ?>

        <div class="requisition-form-card si-requisition-panel">
        <div class="requisition-form-grid si-form-grid">
            <section class="requisition-section-card si-form-card">
                <h4 class="si-form-section-title"><i class="bi bi-person-badge"></i> Staff Information</h4>
                <?php if ($isStaff): ?>
                    <div class="readonly-field readonly-field-icon si-form-group">
                        <label class="si-form-label">Staff Name</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-person"></i></span>
                            <div class="si-readonly-field"><?= h($staffName) ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="req-icon-control si-form-group">
                        <label class="si-form-label">Staff Name</label>
                        <div class="si-input-wrap">
                            <span class="si-input-icon"><i class="bi bi-person"></i></span>
                        <?= $this->Form->control('staff_id', [
                            'options' => $staffs,
                            'label' => false,
                            'class' => 'form-select',
                        ]) ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="readonly-field readonly-field-icon si-form-group">
                    <label class="si-form-label">Department</label>
                    <div class="si-input-wrap">
                        <span class="si-input-icon"><i class="bi bi-building"></i></span>
                        <div class="si-readonly-field"><?= h($staffDepartment) ?></div>
                    </div>
                </div>
                <div class="readonly-field readonly-field-icon si-form-group">
                    <label class="si-form-label">Position</label>
                    <div class="si-input-wrap">
                        <span class="si-input-icon"><i class="bi bi-briefcase"></i></span>
                        <div class="si-readonly-field"><?= h($staffPosition) ?></div>
                    </div>
                </div>
            </section>

            <section class="requisition-section-card si-form-card">
                <h4 class="si-form-section-title"><i class="bi bi-calendar2-check"></i> Request Information</h4>
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
                        'default' => 'Normal',
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
            <small class="textarea-counter">0 / 500 characters</small>
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
                <button type="button" id="add-item-btn" class="req-btn req-btn-gradient req-add-item-btn add-item-btn" data-add-request-row>
                    <i class="bi bi-plus-lg"></i> Add Another Item
                </button>
            </div>
            <div class="requested-items-table-wrap">
                <table class="requested-items-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Available Stock</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody data-request-items-body>
                        <tr>
                            <td data-label="#"><span class="row-number">1</span></td>
                            <td data-label="Item" class="requested-item-select-cell">
                                <?= $this->Form->control('item._ids', [
                                    'options' => $item,
                                    'default' => $selectedItemIds ?? [],
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
                                    'value' => 1,
                                    'required' => true,
                                    'label' => false,
                                    'class' => 'form-control',
                                ]) ?>
                            </td>
                            <td data-label="Available Stock"><span class="stock-chip"><i></i> Available</span></td>
                            <td data-label="Unit"><span class="unit-chip">Unit</span></td>
                            <td data-label="Action">
                                <button type="button" class="remove-row-btn remove-item-btn delete-item-btn" aria-label="Remove item row">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="requisition-form-actions">
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'req-btn req-btn-outline']) ?>
            <?= $this->Form->button('<i class="bi bi-send"></i> Submit Requisition', ['class' => 'req-btn req-btn-gradient', 'escapeTitle' => false]) ?>
        </div>
        </div>
        <?= $this->Form->end() ?>
    </section>
</div>
