<?php
/**
 * @var \App\View\AppView $this
 */
$appName = 'Smart Inventory';
$currentRole = $currentRole ?? null;
$currentUser = $currentUser ?? null;
$controller = (string)$this->request->getParam('controller');
$currentAction = (string)$this->request->getParam('action');
$userImage = $currentUser['image'] ?? null;
$avatar = $userImage ? (str_starts_with($userImage, 'uploads/') ? '/' . $userImage : $userImage) : 'default-avatar.svg';
$adminNav = [
    ['Dashboard', 'Admin', 'dashboard', 'bi-speedometer2'],
    ['Admin', 'Admin', 'index', 'bi-person-gear'],
    ['Staff', 'Staff', 'index', 'bi-people'],
    ['Category', 'Category', 'index', 'bi-tags'],
    ['Item Catalog', 'Item', 'index', 'bi-box-seam'],
    ['Vendor', 'Vendor', 'index', 'bi-building'],
    ['Requisition', 'Requisition', 'index', 'bi-clipboard-check'],
    ['Requisition Item', 'RequisitionItem', 'index', 'bi-list-check'],
    ['Stock Transaction', 'StockTransaction', 'index', 'bi-arrow-left-right'],
    ['Reports', 'Reports', 'index', 'bi-bar-chart-line'],
];
$staffNav = [
    ['Dashboard', 'Staff', 'dashboard', 'bi-speedometer2'],
    ['My Profile', 'Staff', 'view', 'bi-person-circle', $currentUser['id'] ?? null],
    ['Item Catalog', 'Item', 'index', 'bi-box-seam'],
    ['My Requests', 'Requisition', 'index', 'bi-clipboard-data'],
];
$navItems = $currentRole === 'admin' ? $adminNav : $staffNav;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($appName) ?>: <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'inventory', 'custom', 'custom-final']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="premium-ui <?= $currentRole ? 'app-mode' : 'public-mode' ?>" data-theme="dark">
    <div class="particle-field" aria-hidden="true">
        <span></span><span></span><span></span><span></span><span></span>
    </div>

    <?php if (!$currentRole): ?>
        <nav class="landing-nav navbar navbar-expand-lg">
            <div class="container-fluid">
                <?= $this->Html->link('<i class="bi bi-boxes"></i> SmartInventory', '/', ['class' => 'navbar-brand', 'escape' => false]) ?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#landingMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="landingMenu">
                    <div class="navbar-nav ms-auto align-items-lg-center">
                        <?= $this->Html->link('Home', '/', ['class' => 'nav-link']) ?>
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>#features">Features</a>
                        <a class="nav-link" href="<?= $this->Url->build('/') ?>#about">About</a>
                        <?= $this->Html->link('Login', ['controller' => 'Login', 'action' => 'index'], ['class' => 'nav-link']) ?>
                        <button class="theme-toggle-btn ms-lg-3" id="themeTogglePublic" type="button" data-theme-toggle aria-label="Toggle theme">
                            <i class="bi bi-moon-stars"></i><span>Dark Mode</span>
                        </button>
                        <?= $this->Html->link('Get Started', ['controller' => 'Login', 'action' => 'index'], ['class' => 'btn btn-primary ms-lg-3']) ?>
                    </div>
                </div>
            </div>
        </nav>
        <main class="public-main">
            <div class="container-fluid">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
            <footer class="site-footer">
                <strong>Smart Inventory System © 2026. All Rights Reserved.</strong>
                <span>Developed for Smart Inventory &amp; Office Supplies Requisition Portal.</span>
            </footer>
        </main>
    <?php else: ?>
        <div class="app-shell">
            <aside class="app-sidebar sidebar-shell" id="appSidebar">
                <div class="sidebar-inner">
                    <div class="sidebar-brand">
                        <i class="bi bi-boxes"></i>
                        <div>
                            <strong>SmartInventory</strong>
                            <span><?= h(ucfirst($currentRole)) ?> Portal</span>
                        </div>
                    </div>
                    <div class="sidebar-profile">
                        <?= $this->Html->image($avatar, ['alt' => $currentUser['name'] ?? 'User']) ?>
                        <div>
                            <strong><?= h($currentUser['name'] ?? 'User') ?></strong>
                            <span><?= h($currentUser['email'] ?? ucfirst($currentRole)) ?></span>
                        </div>
                    </div>
                    <nav class="sidebar-menu">
                        <?php foreach ($navItems as $item): ?>
                            <?php
                                [$label, $navController, $action, $icon] = $item;
                                $id = $item[4] ?? null;
                                $url = ['controller' => $navController, 'action' => $action];
                                if ($id !== null) {
                                    $url[] = $id;
                                }
                                $active = $controller === $navController && $currentAction === $action ? 'active' : '';
                            ?>
                            <?= $this->Html->link(
                                '<i class="bi ' . h($icon) . '"></i><span>' . h($label) . '</span>',
                                $url,
                                ['class' => 'sidebar-link ' . $active, 'escape' => false]
                            ) ?>
                        <?php endforeach; ?>
                    </nav>
                    <div class="sidebar-footer">
                        <?= $this->Html->link('<i class="bi bi-box-arrow-left"></i><span>Logout</span>', ['controller' => 'Login', 'action' => 'logout'], ['class' => 'sidebar-link logout-link', 'escape' => false]) ?>
                    </div>
                </div>
            </aside>

            <section class="app-main">
                <header class="app-topbar">
                    <button class="icon-btn" id="sidebarToggle" type="button" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
                    <div class="topbar-search">
                        <i class="bi bi-search"></i>
                        <input type="search" data-table-search placeholder="Search current table...">
                    </div>
                    <button class="icon-btn notification-toggle" type="button" data-notification-toggle>
                        <i class="bi bi-bell"></i><span></span>
                    </button>
                    <button class="theme-toggle-btn" id="themeToggle" type="button" data-theme-toggle aria-label="Toggle theme">
                        <i class="bi bi-moon-stars"></i><span>Dark Mode</span>
                    </button>
                    <div class="topbar-user">
                        <?= $this->Html->image($avatar, ['alt' => $currentUser['name'] ?? 'User']) ?>
                        <div>
                            <strong><?= h($currentUser['name'] ?? 'User') ?></strong>
                            <span><?= h(ucfirst($currentRole)) ?></span>
                        </div>
                    </div>
                    <div class="notification-panel" data-notification-panel>
                        <strong>Notifications</strong>
                        <p>Low stock alerts, pending requisitions, and transaction updates will appear here.</p>
                    </div>
                </header>
                <main class="content-area">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                    <footer class="site-footer">
                        <strong>Smart Inventory System © 2026. All Rights Reserved.</strong>
                        <span>Developed for Smart Inventory &amp; Office Supplies Requisition Portal.</span>
                    </footer>
                </main>
            </section>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <?= $this->Html->script('/js/custom.js?v=20260709-clickfix') ?>
    <?= $this->fetch('script') ?>
</body>
</html>





