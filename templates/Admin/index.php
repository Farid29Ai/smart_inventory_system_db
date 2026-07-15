<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Admin> $admin
 */
$formatAdminDate = function ($value): string {
    if (empty($value)) {
        return '-';
    }
    if (is_object($value) && method_exists($value, 'format')) {
        return $value->format('n/j/y,') . '<br>' . $value->format('h:i A');
    }

    return h((string)$value);
};
?>
<div class="admin index content admin-crud-page">
    <div class="admin-crud-header">
        <div>
            <h1>Admin Management</h1>
            <p>Manage administrator accounts and system access.</p>
        </div>
        <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Admin', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
    </div>
    <div class="table-responsive table-scroll-wrapper admin-crud-table-card">
        <table class="table admin-table">
            <colgroup>
                <col style="width:5%">
                <col style="width:16%">
                <col style="width:18%">
                <col style="width:13%">
                <col style="width:12%">
                <col style="width:10%">
                <col style="width:12%">
                <col style="width:14%">
            </colgroup>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('admin_id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('admin_name', 'Name') ?></th>
                    <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                    <th><?= $this->Paginator->sort('phone_no', 'Phone') ?></th>
                    <th><?= $this->Paginator->sort('admin_level', 'Role') ?></th>
                    <th><?= $this->Paginator->sort('profile_image', 'Photo') ?></th>
                    <th class="created-at"><?= $this->Paginator->sort('created_at', 'Created') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admin as $adminEntity): ?>
                <tr>
                    <td><?= $this->Number->format($adminEntity->admin_id) ?></td>
                    <td><?= h($adminEntity->admin_name) ?></td>
                    <td><?= h($adminEntity->email) ?></td>
                    <td><?= h($adminEntity->phone_no) ?></td>
                    <td><?= h($adminEntity->admin_level) ?></td>
                    <td>
                        <?php if (!empty($adminEntity->profile_image)): ?>
                            <?= $this->Html->image($adminEntity->profile_image, ['alt' => $adminEntity->admin_name, 'class' => 'table-thumb']) ?>
                        <?php else: ?>
                            <?= $this->Html->image('default-avatar.svg', ['alt' => 'Default avatar', 'class' => 'table-thumb']) ?>
                        <?php endif; ?>
                    </td>
                    <td class="admin-date-cell created-at"><?= $formatAdminDate($adminEntity->created_at) ?></td>
                    <td class="actions-cell">
                        <div class="action-group">
                            <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $adminEntity->admin_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $adminEntity->admin_id], ['class' => 'action-icon-btn action-edit edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                            <?= $this->Form->postButton(
                                '<i class="bi bi-trash"></i>',
                                ['action' => 'delete', $adminEntity->admin_id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $adminEntity->admin_id),
                                    'class' => 'action-icon-btn action-delete delete-btn',
                                    'aria-label' => __('Delete'),
                                    'title' => __('Delete'),
                                    'escapeTitle' => false,
                                ]
                            ) ?>
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
