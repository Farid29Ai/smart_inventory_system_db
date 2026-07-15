<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Login');
?>
<section class="premium-auth enterprise-login-page">
    <div class="enterprise-light light-one"></div>
    <div class="enterprise-light light-two"></div>
    <div class="enterprise-wave-grid" aria-hidden="true"></div>
    <div class="enterprise-login-particles" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
    <div class="enterprise-floating-icons" aria-hidden="true">
        <i class="bi bi-box-seam"></i>
        <i class="bi bi-clipboard-check"></i>
        <i class="bi bi-database"></i>
        <i class="bi bi-person-circle"></i>
        <i class="bi bi-cart3"></i>
        <i class="bi bi-graph-up-arrow"></i>
    </div>

    <div class="enterprise-login-card animate__animated animate__fadeInUp" data-aos="zoom-in">
        <p class="enterprise-login-badge">Secure Role Access</p>
        <h1 class="enterprise-login-title">Sign in to<br>Smart Inventory</h1>
        <p class="enterprise-login-subtitle">One login gateway for admins and staff.<br>Your role decides the dashboard and access level.</p>

        <?= $this->Form->create(null, ['class' => 'enterprise-login-form', 'data-loading-form' => true]) ?>
            <label>Email Address</label>
            <div class="enterprise-field">
                <i class="bi bi-envelope"></i>
                <?= $this->Form->email('email', ['required' => true, 'placeholder' => 'name@example.com', 'label' => false]) ?>
            </div>

            <label>Password</label>
            <div class="enterprise-field">
                <i class="bi bi-lock"></i>
                <?= $this->Form->password('password', ['required' => true, 'placeholder' => 'Enter your password', 'id' => 'enterprise-login-password', 'label' => false]) ?>
                <button type="button" class="enterprise-password-toggle" data-password-toggle="enterprise-login-password" aria-label="Show or hide password"><i class="bi bi-eye"></i></button>
            </div>

            <div class="enterprise-login-options">
                <label class="enterprise-remember"><?= $this->Form->checkbox('remember_me') ?> <span>Remember Me</span></label>
                <a href="#">Forgot Password?</a>
            </div>

            <?= $this->Form->button('<span class="btn-text"><i class="bi bi-shield-check"></i> Login Securely</span><span class="btn-loader"></span>', ['class' => 'enterprise-login-button', 'escapeTitle' => false]) ?>
        <?= $this->Form->end() ?>

        <div class="enterprise-login-divider"><span>OR</span></div>
        <div class="enterprise-role-select">
            <?= $this->Html->link('<i class="bi bi-person-gear"></i><strong>Admin Login</strong><span>Login as administrator</span>', ['controller' => 'Admin', 'action' => 'login'], ['class' => 'enterprise-role-option', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="bi bi-people"></i><strong>Staff Login</strong><span>Login as staff member</span>', ['controller' => 'Staff', 'action' => 'login'], ['class' => 'enterprise-role-option', 'escape' => false]) ?>
        </div>
    </div>
</section>
