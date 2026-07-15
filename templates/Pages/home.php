<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Home');
?>
<section class="landing-hero" id="home">
    <div class="hero-grid">
        <div class="hero-content">
            <span class="hero-pill"><i class="bi bi-stars"></i> Enterprise Inventory Solution</span>
            <h1>Smart Inventory & Office Supplies Requisition Portal</h1>
            <p class="hero-subtitle">Manage inventory, stock movement, office supply requests, vendor records and approvals efficiently through one centralized platform.</p>
            <div class="typing-line">
                <span>Smart system for </span><strong data-typing data-words="Inventory Tracking,Requisition Management,Vendor Management,Stock Monitoring,Smart Reporting"></strong>
            </div>
            <div class="hero-actions">
                <?= $this->Html->link('Admin Login', ['controller' => 'Admin', 'action' => 'login'], ['class' => 'btn btn-outline-light btn-lg']) ?>
                <?= $this->Html->link('Staff Login', ['controller' => 'Staff', 'action' => 'login'], ['class' => 'btn btn-success btn-lg']) ?>
                <a class="btn btn-ghost btn-lg" href="#features">Explore Features</a>
            </div>
        </div>
        <div class="dashboard-preview premium-glass">
            <div class="preview-top">
                <span></span><span></span><span></span>
            </div>
            <div class="homepage-preview-grid">
                <article>
                    <i class="bi bi-box-seam"></i>
                    <span>Total Item Catalog</span>
                    <strong>1,250</strong>
                </article>
                <article>
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Low Stock Alerts</span>
                    <strong>12</strong>
                </article>
                <article>
                    <i class="bi bi-clipboard-check"></i>
                    <span>Pending Requisitions</span>
                    <strong>18</strong>
                </article>
                <article>
                    <i class="bi bi-building"></i>
                    <span>Vendors</span>
                    <strong>32</strong>
                </article>
                <article>
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Stock Transactions</span>
                    <strong>4,800</strong>
                </article>
                <article class="analytics-card">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Inventory Analytics</span>
                    <div class="mini-bars" aria-hidden="true"><b></b><b></b><b></b><b></b><b></b></div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="feature-section" id="features">
    <div class="section-heading">
        <span>Key Features</span>
        <h2>Built for fast stock control and clean requisition workflows</h2>
    </div>
    <div class="feature-grid">
        <article class="feature-card">
            <i class="bi bi-activity"></i>
            <h3>Real-time Stock Tracking</h3>
            <p>Monitor item catalog quantities, low-stock levels and movement from one elegant dashboard.</p>
        </article>
        <article class="feature-card">
            <i class="bi bi-clipboard2-check"></i>
            <h3>Smart Requisition</h3>
            <p>Staff can request office supplies while admin reviews and approves each request.</p>
        </article>
        <article class="feature-card">
            <i class="bi bi-building-check"></i>
            <h3>Vendor Management</h3>
            <p>Keep supplier contacts, phone numbers, email and addresses organized.</p>
        </article>
        <article class="feature-card">
            <i class="bi bi-shield-lock"></i>
            <h3>Secure Role Access</h3>
            <p>Admin and staff enter different dashboards with access control for each role.</p>
        </article>
        <article class="feature-card">
            <i class="bi bi-graph-up-arrow"></i>
            <h3>Reports & Analytics</h3>
            <p>Use statistic cards and charts to understand requisitions and stock activity.</p>
        </article>
    </div>
</section>

<section class="about-band premium-glass" id="about">
    <div>
        <span>Smart Inventory Solutions for Modern Organizations</span>
        <h2>Streamline inventory operations, manage office supplies efficiently and improve requisition workflows with a secure and intelligent management platform.</h2>
    </div>
    <?= $this->Html->link('Access Portal', ['controller' => 'Login', 'action' => 'index'], ['class' => 'btn btn-primary btn-lg']) ?>
</section>
