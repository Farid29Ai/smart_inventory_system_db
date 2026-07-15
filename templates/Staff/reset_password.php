<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staffEntity
 */
$this->assign('title', 'Reset Staff Password');
?>
<section class="auth-wrap role-login-page forgot-password-page auth-recovery-page staff-reset-page">
    <div class="auth-card role-login-card reset-card auth-recovery-card reset-password-card staff-auth-card">
        <div class="auth-form-panel reset-form-panel">
            <p class="eyebrow role-login-badge">Staff Password Reset</p>
            <h1 class="role-login-title">Reset Password</h1>
            <p class="role-login-description">Create a new password for <?= h($staffEntity->email) ?>.</p>

            <?= $this->Form->create(null, ['class' => 'auth-form role-login-form split-login-form', 'data-loading-form' => true]) ?>
                <div class="split-field">
                    <label for="staff-reset-password">New Password</label>
                    <div class="split-input-shell">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="staff-reset-password" required minlength="6" placeholder="Enter new password" autocomplete="new-password">
                        <button type="button" class="split-password-toggle" data-password-toggle="staff-reset-password" aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="split-field">
                    <label for="staff-reset-confirm-password">Confirm Password</label>
                    <div class="split-input-shell">
                        <i class="bi bi-shield-lock"></i>
                        <input type="password" name="confirm_password" id="staff-reset-confirm-password" required minlength="6" placeholder="Confirm new password" autocomplete="new-password">
                        <button type="button" class="split-password-toggle" data-password-toggle="staff-reset-confirm-password" aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <?= $this->Form->button('<i class="bi bi-check-circle"></i> Reset Password', ['class' => 'btn btn-success role-login-btn split-login-submit staff-submit w-100', 'escapeTitle' => false]) ?>
            <?= $this->Form->end() ?>

            <div class="auth-switch role-login-switch">
                <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to Staff Login', ['controller' => 'Staff', 'action' => 'login'], ['escape' => false]) ?>
            </div>
        </div>
    </div>
</section>
