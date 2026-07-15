<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin $adminEntity
 */
$profileImage = !empty($adminEntity->profile_image) ? $adminEntity->profile_image : 'default-avatar.svg';
?>
<section class="profile-dashboard">
    <aside class="profile-summary-card">
        <div class="profile-avatar-wrap">
            <?= $this->Html->image($profileImage, ['alt' => $adminEntity->admin_name, 'class' => 'profile-avatar-xl']) ?>
            <span class="profile-camera-badge"><i class="bi bi-camera"></i></span>
        </div>
        <span class="profile-role-badge">Admin Profile</span>
        <h1><?= h($adminEntity->admin_name) ?></h1>
        <p><?= h($adminEntity->admin_level ?: 'Administrator') ?></p>

        <div class="profile-meta-list">
            <span><i class="bi bi-shield-check"></i><?= h($adminEntity->admin_level ?: 'Admin') ?></span>
            <span><i class="bi bi-envelope"></i><?= h($adminEntity->email) ?></span>
            <span><i class="bi bi-telephone"></i><?= h($adminEntity->phone_no ?: 'Phone not set') ?></span>
        </div>

        <div class="profile-about">
            <h2>About</h2>
            <p>Administrator account for inventory oversight, approvals, staff management and reporting.</p>
        </div>

        <?= $this->Html->link('<i class="bi bi-camera"></i> Change Photo', ['action' => 'edit', $adminEntity->admin_id], ['class' => 'btn btn-primary profile-action-btn', 'escape' => false]) ?>
    </aside>

    <div class="profile-detail-card">
        <div class="profile-section-head">
            <div>
                <span class="profile-section-kicker">Admin Profile</span>
                <h2>Account Details</h2>
                <p>View administrator identity, contact information and account level.</p>
            </div>
            <div class="profile-toolbar">
                <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Edit Admin', ['action' => 'edit', $adminEntity->admin_id], ['class' => 'btn btn-primary', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="bi bi-list"></i> List Admin', ['action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
                <?= $this->Form->postLink(
                    '<i class="bi bi-trash"></i> Delete Admin',
                    ['action' => 'delete', $adminEntity->admin_id],
                    [
                        'confirm' => __('Are you sure you want to delete {0}?', $adminEntity->admin_name),
                        'class' => 'btn btn-danger profile-delete-btn',
                        'escapeTitle' => false,
                    ]
                ) ?>
            </div>
        </div>

        <div class="profile-info-grid">
            <article>
                <span>Full Name</span>
                <strong><?= h($adminEntity->admin_name) ?></strong>
            </article>
            <article>
                <span>Email</span>
                <strong><?= h($adminEntity->email) ?></strong>
            </article>
            <article>
                <span>Phone Number</span>
                <strong><?= h($adminEntity->phone_no ?: '-') ?></strong>
            </article>
            <article>
                <span>Username</span>
                <strong><?= h($adminEntity->email) ?></strong>
            </article>
            <article>
                <span>Department</span>
                <strong>Administration</strong>
            </article>
            <article>
                <span>Position</span>
                <strong><?= h($adminEntity->admin_level ?: 'Administrator') ?></strong>
            </article>
            <article>
                <span>Admin ID</span>
                <strong><?= $this->Number->format($adminEntity->admin_id) ?></strong>
            </article>
            <article>
                <span>Created At</span>
                <strong><?= h($adminEntity->created_at ?: '-') ?></strong>
            </article>
        </div>
    </div>
</section>
