<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Settings');
?>
<section class="dashboard-head">
    <div>
        <p class="eyebrow">System Settings</p>
        <h1>Portal Settings</h1>
        <p>Manage profile, preferences and portal configuration from a dedicated admin settings workspace.</p>
    </div>
</section>

<section class="stat-grid">
    <article class="stat-card stat-blue">
        <i class="bi bi-person-gear"></i>
        <span>Admin Profile</span>
        <strong>Ready</strong>
    </article>
    <article class="stat-card stat-cyan">
        <i class="bi bi-shield-check"></i>
        <span>Role Access</span>
        <strong>Active</strong>
    </article>
    <article class="stat-card stat-purple">
        <i class="bi bi-palette"></i>
        <span>Theme</span>
        <strong>Dark / Light</strong>
    </article>
</section>

<section class="content-panel">
    <div class="panel-title">
        <h2>Quick Settings Links</h2>
    </div>
    <div class="settings-actions">
        <?= $this->Html->link('<i class="bi bi-person-gear"></i> Manage Admin', ['controller' => 'Admin', 'action' => 'index'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="bi bi-people"></i> Manage Staff', ['controller' => 'Staff', 'action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="bi bi-bar-chart-line"></i> Reports', ['controller' => 'Reports', 'action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
    </div>
</section>
