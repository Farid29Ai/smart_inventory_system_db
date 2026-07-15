<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin $adminEntity
 */
$this->assign('title', 'Reset Admin Password');
?>
<section class="auth-wrap role-login-page forgot-password-page auth-recovery-page admin-reset-page">
    <div class="auth-card role-login-card reset-card auth-recovery-card reset-password-card admin-auth-card">
        <div class="auth-form-panel reset-form-panel">
            <p class="eyebrow role-login-badge">Admin Password Reset</p>
            <h1 class="role-login-title">Reset Password</h1>
            <p class="role-login-description">Create a new password for <?= h($adminEntity->email) ?>.</p>

            <?= $this->Form->create(null, ['class' => 'auth-form role-login-form split-login-form', 'data-loading-form' => true]) ?>
                <div class="split-field">
                    <label for="admin-reset-password">New Password</label>
                    <div class="split-input-shell">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="admin-reset-password" required minlength="6" placeholder="Enter new password" autocomplete="new-password">
                        <button type="button" class="split-password-toggle" data-password-toggle="admin-reset-password" aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="split-field">
                    <label for="admin-reset-confirm-password">Confirm Password</label>
                    <div class="split-input-shell">
                        <i class="bi bi-shield-lock"></i>
                        <input type="password" name="confirm_password" id="admin-reset-confirm-password" required minlength="6" placeholder="Confirm new password" autocomplete="new-password">
                        <button type="button" class="split-password-toggle" data-password-toggle="admin-reset-confirm-password" aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <?= $this->Form->button('<i class="bi bi-check-circle"></i> Reset Password', ['class' => 'btn btn-primary role-login-btn split-login-submit admin-submit w-100', 'escapeTitle' => false]) ?>
            <?= $this->Form->end() ?>

            <div class="auth-switch role-login-switch">
                <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to Admin Login', ['controller' => 'Admin', 'action' => 'login'], ['escape' => false]) ?>
            </div>
        </div>
    </div>
</section>
