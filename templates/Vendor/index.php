<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Vendor> $vendor
 */
$rowNumber = (int)$this->Paginator->counter('{{start}}');
?>
<div class="vendor index content admin-crud-page">
    <div class="admin-crud-header">
        <div>
            <h1>Vendor Management</h1>
            <p>Manage supplier records, contacts and vendor information.</p>
        </div>
        <?php if (($currentRole ?? null) === 'admin'): ?>
            <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Vendor', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
        <?php endif; ?>
    </div>
    <div class="table-responsive table-scroll-wrapper admin-crud-table-card">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th><?= __('ID') ?></th>
                    <th><?= $this->Paginator->sort('vendor_name') ?></th>
                    <th><?= $this->Paginator->sort('contact_person') ?></th>
                    <th><?= $this->Paginator->sort('phone_no') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendor as $vendorEntity): ?>
                <tr>
                    <td><?= $this->Number->format($rowNumber++) ?></td>
                    <td><?= h($vendorEntity->vendor_name) ?></td>
                    <td><?= h($vendorEntity->contact_person) ?></td>
                    <td><?= h($vendorEntity->phone_no) ?></td>
                    <td><?= h($vendorEntity->email) ?></td>
                    <td class="actions-cell">
                        <div class="action-group">
                            <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $vendorEntity->vendor_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            <?php if (($currentRole ?? null) === 'admin'): ?>
                                <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $vendorEntity->vendor_id], ['class' => 'action-icon-btn action-edit edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                                <?= $this->Form->postButton(
                                    '<i class="bi bi-trash"></i>',
                                    ['action' => 'delete', $vendorEntity->vendor_id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $vendorEntity->vendor_id),
                                        'class' => 'action-icon-btn action-delete delete-btn',
                                        'aria-label' => __('Delete'),
                                        'title' => __('Delete'),
                                        'escapeTitle' => false,
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
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
