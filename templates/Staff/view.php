<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staffEntity
 */
$isOwnProfile = (($currentRole ?? null) === 'staff' && (int)($currentUser['id'] ?? 0) === (int)$staffEntity->staff_id);
$profileImage = !empty($staffEntity->profile_image) ? $staffEntity->profile_image : 'default-avatar.svg';
?>
<section class="staff-profile-page">
    <aside class="staff-profile-panel">
        <div class="staff-profile-avatar-wrap">
            <?= $this->Html->image($profileImage, ['alt' => $staffEntity->staff_name, 'class' => 'staff-profile-avatar']) ?>
            <span><i class="bi bi-camera"></i></span>
        </div>
        <h1><?= h($staffEntity->staff_name) ?></h1>
        <p><?= h($staffEntity->position ?: 'Staff Member') ?></p>
        <div class="staff-profile-panel-list">
            <span><i class="bi bi-building"></i><?= h($staffEntity->department ?: 'Department not set') ?></span>
            <span><i class="bi bi-envelope"></i><?= h($staffEntity->email) ?></span>
            <span><i class="bi bi-telephone"></i><?= h($staffEntity->phone_no ?: 'Phone not set') ?></span>
            <span><i class="bi bi-calendar-check"></i>Joined: <?= h($staffEntity->created_at ?: '-') ?></span>
        </div>
        <?php if ($isOwnProfile): ?>
            <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Edit Profile', ['action' => 'edit', $staffEntity->staff_id], ['class' => 'btn btn-light staff-profile-edit-link', 'escape' => false]) ?>
        <?php endif; ?>
    </aside>

    <article class="staff-profile-card">
        <div class="staff-profile-card-head">
            <div>
                <span>PROFILE</span>
                <h2>Your Personal Profile Info</h2>
                <p>Review your SmartInventory staff account information.</p>
            </div>
            <?php if (($currentRole ?? null) === 'admin'): ?>
                <div class="profile-toolbar staff-view-toolbar">
                    <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Edit Staff', ['action' => 'edit', $staffEntity->staff_id], ['class' => 'btn btn-primary', 'escape' => false]) ?>
                    <?= $this->Html->link('<i class="bi bi-list"></i> List Staff', ['action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
                    <?= $this->Form->postLink(
                        '<i class="bi bi-trash"></i> Delete Staff',
                        ['action' => 'delete', $staffEntity->staff_id],
                        [
                            'confirm' => __('Are you sure you want to delete {0}?', $staffEntity->staff_name),
                            'class' => 'btn btn-danger profile-delete-btn',
                            'escapeTitle' => false,
                        ]
                    ) ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="staff-profile-info-grid">
            <div>
                <label>Staff ID</label>
                <strong><?= $this->Number->format($staffEntity->staff_id) ?></strong>
            </div>
            <div>
                <label>Staff Name</label>
                <strong><?= h($staffEntity->staff_name) ?></strong>
            </div>
            <div>
                <label>Email</label>
                <strong><?= h($staffEntity->email) ?></strong>
            </div>
            <div>
                <label>Phone Number</label>
                <strong><?= h($staffEntity->phone_no ?: '-') ?></strong>
            </div>
            <div>
                <label>Department</label>
                <strong><?= h($staffEntity->department ?: '-') ?></strong>
            </div>
            <div>
                <label>Position</label>
                <strong><?= h($staffEntity->position ?: '-') ?></strong>
            </div>
            <div>
                <label>Joined Date</label>
                <strong><?= h($staffEntity->created_at ?: '-') ?></strong>
            </div>
            <div>
                <label>Account Status</label>
                <strong><span class="staff-status-pill">Active</span></strong>
            </div>
        </div>
    </article>
</section>
