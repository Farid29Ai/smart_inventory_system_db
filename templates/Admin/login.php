<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Admin Login');
$this->append('css');
?>
<style>
body.premium-ui.public-mode .admin-login-page .split-input-shell {
    align-items: center !important;
    background: rgba(15, 23, 42, .72) !important;
    border: 1px solid rgba(148, 163, 184, .30) !important;
    border-radius: 16px !important;
    box-shadow: none !important;
    display: flex !important;
    gap: 0 !important;
    height: 58px !important;
    overflow: hidden !important;
    padding: 0 !important;
    width: 100% !important;
}

body.premium-ui.public-mode .admin-login-page .split-input-shell > i {
    align-items: center !important;
    align-self: stretch !important;
    background: transparent !important;
    border: 0 !important;
    color: #60A5FA !important;
    display: inline-flex !important;
    flex: 0 0 58px !important;
    font-size: 22px !important;
    height: 58px !important;
    justify-content: center !important;
    left: auto !important;
    margin: 0 !important;
    min-width: 58px !important;
    padding: 0 !important;
    position: static !important;
    top: auto !important;
    transform: none !important;
    width: 58px !important;
}

body.premium-ui.public-mode .admin-login-page .split-input-shell input {
    -webkit-appearance: none !important;
    -webkit-text-fill-color: currentColor !important;
    appearance: none !important;
    background: transparent !important;
    border: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    color: #FFFFFF !important;
    flex: 1 1 auto !important;
    font-size: 16px !important;
    font-weight: 700 !important;
    height: 58px !important;
    line-height: 58px !important;
    margin: 0 !important;
    min-width: 0 !important;
    outline: 0 !important;
    padding: 0 18px !important;
    width: 100% !important;
}

body.premium-ui.public-mode .admin-login-page .split-input-shell input:focus,
body.premium-ui.public-mode .admin-login-page .split-input-shell input:hover {
    background: transparent !important;
    border: 0 !important;
    box-shadow: none !important;
    outline: 0 !important;
}

body.premium-ui.public-mode .admin-login-page .split-password-toggle {
    align-items: center !important;
    align-self: stretch !important;
    background: transparent !important;
    border: 0 !important;
    border-left: 1px solid rgba(148, 163, 184, .24) !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    color: #60A5FA !important;
    display: inline-flex !important;
    flex: 0 0 58px !important;
    height: 58px !important;
    justify-content: center !important;
    margin: 0 !important;
    min-width: 58px !important;
    padding: 0 !important;
    position: static !important;
    transform: none !important;
    width: 58px !important;
}

body.premium-ui[data-theme="light"].public-mode .admin-login-page .split-input-shell {
    background: #FFFFFF !important;
    border-color: #CBD5E1 !important;
}

body.premium-ui[data-theme="light"].public-mode .admin-login-page .split-input-shell input {
    color: #0F172A !important;
}

body.premium-ui[data-theme="light"].public-mode .admin-login-page .split-input-shell input::placeholder {
    color: #64748B !important;
}

body.premium-ui[data-theme="light"].public-mode .admin-login-page .split-input-shell > i,
body.premium-ui[data-theme="light"].public-mode .admin-login-page .split-password-toggle {
    color: #2563EB !important;
}
</style>
<?php
$this->end();
?>
<section class="auth-wrap role-login-page split-login-page admin-login-page">
    <div class="auth-card role-login-card split-login-card admin-auth-card">
        <div class="auth-info-panel">
            <p class="eyebrow role-login-badge">Administrator Access</p>
            <h1 class="role-login-title">Admin Login</h1>
            <p class="role-login-description">Secure administrator access to manage inventory, approvals, vendors, reports and system settings.</p>

            <div class="auth-illustration admin-illustration" aria-hidden="true">
                <span class="orbit-dot orbit-one"><i class="bi bi-clipboard-check"></i></span>
                <span class="orbit-dot orbit-two"><i class="bi bi-box-seam"></i></span>
                <span class="orbit-dot orbit-three"><i class="bi bi-people"></i></span>
                <span class="orbit-dot orbit-four"><i class="bi bi-bar-chart-line"></i></span>
                <div class="auth-orbit-ring"></div>
                <div class="auth-core-icon"><i class="bi bi-shield-lock-fill"></i></div>
            </div>
        </div>

        <div class="auth-form-panel">
            <?= $this->Form->create(null, ['class' => 'auth-form role-login-form split-login-form', 'data-loading-form' => true]) ?>
                <div class="split-field">
                    <label for="admin-login-email">Email Address</label>
                    <div class="split-input-shell">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" id="admin-login-email" required placeholder="admin@example.com" autocomplete="email">
                    </div>
                </div>
                <div class="split-field">
                    <label for="admin-login-password">Password</label>
                    <div class="split-input-shell">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" id="admin-login-password" required placeholder="Enter password" autocomplete="current-password">
                        <button type="button" class="split-password-toggle" data-password-toggle="admin-login-password" aria-label="Show or hide password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="forgot-password-link">
                        <?= $this->Html->link('Forgot Password?', ['controller' => 'Admin', 'action' => 'forgotPassword']) ?>
                    </div>
                </div>
                <?= $this->Form->button('<i class="bi bi-person-gear"></i> Login as Admin', ['class' => 'btn btn-primary role-login-btn split-login-submit admin-submit w-100', 'escapeTitle' => false]) ?>
            <?= $this->Form->end() ?>

            <div class="auth-switch role-login-switch">
                <span>Need Staff Access?</span>
                <?= $this->Html->link('Staff Login', ['controller' => 'Staff', 'action' => 'login']) ?>
            </div>
        </div>
    </div>
</section>
