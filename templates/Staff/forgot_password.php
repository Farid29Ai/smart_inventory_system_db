<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Forgot Staff Password');
?>
<section class="auth-wrap role-login-page forgot-password-page auth-recovery-page staff-forgot-page">
    <div class="auth-card role-login-card reset-card auth-recovery-card forgot-password-card staff-auth-card">
        <div class="auth-form-panel reset-form-panel">
            <p class="eyebrow role-login-badge">Password Recovery</p>
            <h1 class="role-login-title">Forgot Staff Password</h1>
            <p class="role-login-description">Enter your registered staff email address to reset your password.</p>

            <?= $this->Form->create(null, ['class' => 'auth-form role-login-form split-login-form', 'data-loading-form' => true]) ?>
                <div class="split-field">
                    <label for="staff-forgot-email">Email Address</label>
                    <div class="split-input-shell">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" id="staff-forgot-email" required placeholder="staff@example.com" autocomplete="email">
                    </div>
                </div>

                <?= $this->Form->button('<i class="bi bi-arrow-right-circle"></i> Continue', ['class' => 'btn btn-success role-login-btn split-login-submit staff-submit w-100', 'escapeTitle' => false]) ?>
            <?= $this->Form->end() ?>

            <div class="auth-switch role-login-switch">
                <?= $this->Html->link('<i class="bi bi-arrow-left"></i> Back to Staff Login', ['controller' => 'Staff', 'action' => 'login'], ['escape' => false]) ?>
            </div>
        </div>
    </div>
</section>
