<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Staff> $staff
 */
?>
<div class="staff index content admin-crud-page">
    <div class="admin-crud-header">
        <div>
            <h1>Staff Management</h1>
            <p>Manage staff accounts, departments and contact details.</p>
        </div>
        <?= $this->Html->link('<i class="bi bi-plus-lg"></i> New Staff', ['action' => 'add'], ['class' => 'admin-crud-new-btn', 'escape' => false]) ?>
    </div>
    <div class="table-responsive table-scroll-wrapper admin-crud-table-card">
        <table class="table admin-table">
            <colgroup>
                <col style="width:5%">
                <col style="width:15%">
                <col style="width:16%">
                <col style="width:12%">
                <col style="width:12%">
                <col style="width:9%">
                <col style="width:8%">
                <col style="width:8%">
                <col style="width:15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="staff-id-cell"><?= $this->Paginator->sort('staff_id', 'ID') ?></th>
                    <th class="staff-name-cell"><?= $this->Paginator->sort('staff_name', 'Name') ?></th>
                    <th class="email-cell"><?= $this->Paginator->sort('email', 'Email') ?></th>
                    <th class="phone-cell"><?= $this->Paginator->sort('phone_no', 'Phone') ?></th>
                    <th class="department-cell"><?= $this->Paginator->sort('department', 'Dept') ?></th>
                    <th class="position-cell"><?= $this->Paginator->sort('position', 'Position') ?></th>
                    <th class="profile-image-cell"><?= $this->Paginator->sort('profile_image', 'Photo') ?></th>
                    <th class="created-at-cell created-at"><?= $this->Paginator->sort('created_at', 'Joined') ?></th>
                    <th class="actions actions-column"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff as $staffEntity): ?>
                <tr>
                    <td class="staff-id-cell"><?= $this->Number->format($staffEntity->staff_id) ?></td>
                    <td class="staff-name-cell"><?= h($staffEntity->staff_name) ?></td>
                    <td class="email-cell"><?= h($staffEntity->email) ?></td>
                    <td class="phone-cell"><?= h($staffEntity->phone_no) ?></td>
                    <td class="department-cell"><?= h($staffEntity->department) ?></td>
                    <td class="position-cell"><?= h($staffEntity->position) ?></td>
                    <td class="profile-image-cell">
                        <?php if (!empty($staffEntity->profile_image)): ?>
                            <?= $this->Html->image($staffEntity->profile_image, ['alt' => $staffEntity->staff_name, 'class' => 'table-thumb profile-image']) ?>
                        <?php else: ?>
                            <?= $this->Html->image('default-avatar.svg', ['alt' => 'Default avatar', 'class' => 'table-thumb profile-image']) ?>
                        <?php endif; ?>
                    </td>
                    <td class="created-at-cell created-at">
                        <?php if (!empty($staffEntity->created_at)): ?>
                            <span class="date-text"><?= h($staffEntity->created_at->i18nFormat('dd MMM yy')) ?></span>
                            <span class="time-text"><?= h($staffEntity->created_at->i18nFormat('HH:mm')) ?></span>
                        <?php else: ?>
                            <span class="date-text">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions-cell">
                        <div class="action-group">
                            <?= $this->Html->link('<i class="bi bi-eye"></i>', ['action' => 'view', $staffEntity->staff_id], ['class' => 'action-icon-btn action-view view-btn', 'aria-label' => __('View'), 'title' => __('View'), 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="bi bi-pencil"></i>', ['action' => 'edit', $staffEntity->staff_id], ['class' => 'action-icon-btn action-edit edit-btn', 'aria-label' => __('Edit'), 'title' => __('Edit'), 'escape' => false]) ?>
                            <?= $this->Form->postButton(
                                '<i class="bi bi-trash"></i>',
                                ['action' => 'delete', $staffEntity->staff_id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $staffEntity->staff_id),
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
