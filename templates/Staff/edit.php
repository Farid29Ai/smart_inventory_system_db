<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staffEntity
 */
$isStaffProfile = (($currentRole ?? null) === 'staff');
$profileImage = !empty($staffEntity->profile_image) ? $staffEntity->profile_image : 'default-avatar.svg';
?>
<section class="staff-profile-page staff-profile-edit-page">
    <aside class="staff-profile-panel">
        <div class="staff-profile-avatar-wrap">
            <?= $this->Html->image($profileImage, ['alt' => $staffEntity->staff_name, 'class' => 'staff-profile-avatar live-image-preview-target']) ?>
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
        <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Cancel', $isStaffProfile ? ['action' => 'view', $staffEntity->staff_id] : ['action' => 'index'], ['class' => 'btn btn-light staff-profile-edit-link', 'escape' => false]) ?>
    </aside>

    <article class="staff-profile-card staff-profile-form-card">
        <div class="staff-profile-card-head">
            <div class="profile-header-title">
                <span class="profile-eyebrow">PROFILE SETTINGS</span>
                <h2>Your Personal Profile Info</h2>
            </div>
            <p class="profile-header-description">Update your existing staff details. Password and image upload are optional.</p>
        </div>

        <?= $this->Form->create($staffEntity, ['type' => 'file', 'class' => 'staff-profile-form']) ?>
            <section class="staff-form-section">
                <h3>PROFILE</h3>
                <div class="staff-profile-form-grid">
                    <?= $this->Form->control('staff_name', ['label' => 'Staff Name']) ?>
                    <?= $this->Form->control('email', ['label' => 'Email']) ?>
                    <?= $this->Form->control('phone_no', ['label' => 'Phone Number']) ?>
                    <?= $this->Form->control('department', ['label' => 'Department']) ?>
                    <?= $this->Form->control('position', ['label' => 'Position']) ?>
                    <div class="input text">
                        <label>Staff ID</label>
                        <input type="text" value="<?= h((string)$staffEntity->staff_id) ?>" readonly>
                    </div>
                    <div class="input text">
                        <label>Joined Date</label>
                        <input type="text" value="<?= h((string)($staffEntity->created_at ?: '-')) ?>" readonly>
                    </div>
                </div>
            </section>

            <section class="staff-form-section">
                <h3>PASSWORD</h3>
                <div class="staff-profile-form-grid">
                    <?= $this->Form->control('password', [
                        'required' => false,
                        'value' => '',
                        'label' => 'New Password',
                        'placeholder' => __('Leave blank to keep existing password'),
                    ]) ?>
                    <div class="input password">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Retype new password">
                    </div>
                </div>
            </section>

            <section class="staff-form-section">
                <h3>PROFILE PHOTO</h3>
                <div class="staff-profile-form-grid">
                    <?= $this->Form->control('profile_image', ['type' => 'file', 'accept' => 'image/*', 'label' => 'Upload Profile Image']) ?>
                </div>
            </section>

            <div class="staff-profile-actions">
                <?= $this->Html->link(__('Cancel'), $isStaffProfile ? ['action' => 'view', $staffEntity->staff_id] : ['action' => 'index'], ['class' => 'btn btn-ghost']) ?>
                <?= $this->Form->button(__('Save Changes'), ['class' => 'btn btn-primary']) ?>
            </div>
        <?= $this->Form->end() ?>
    </article>
</section>
