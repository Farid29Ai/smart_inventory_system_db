<?php
/**
 * @var \App\View\AppView $this
 * @var array $stats
 * @var iterable<\App\Model\Entity\Requisition> $recentRequisitions
 * @var array $monthlyRequestLabels
 * @var array $monthlyRequestValues
 * @var array $topRequestedItems
 * @var array $vendorStats
 */
$this->assign('title', 'Admin Dashboard');
$cards = [
    ['Total Staff', $stats['staff'], 'bi-people', 'blue'],
    ['Total Categories', $stats['categories'], 'bi-tags', 'cyan'],
    ['Total Item Catalog', $stats['items'], 'bi-box-seam', 'purple'],
    ['Total Vendors', $stats['vendors'], 'bi-building', 'blue'],
    ['Pending Requisitions', $stats['pending'], 'bi-hourglass-split', 'warning'],
    ['Approved Requisitions', $stats['approved'], 'bi-check2-circle', 'success'],
    ['Low Stock', $stats['lowStock'], 'bi-exclamation-triangle', 'danger'],
    ["Today's Requests", $stats['todayRequests'], 'bi-calendar-check', 'success'],
    ['Stock Transactions', $stats['transactions'], 'bi-arrow-left-right', 'cyan'],
];
?>
<section class="dashboard-head">
    <div>
        <p class="eyebrow">Admin Dashboard</p>
        <h1>Inventory Command Center</h1>
        <p>Track staff, categories, vendors, requisitions, low stock and stock movements in one premium workspace.</p>
    </div>
    <div class="dashboard-actions">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> Add Item Catalog', ['controller' => 'Item', 'action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="bi bi-arrow-left-right"></i> Stock Entry', ['controller' => 'StockTransaction', 'action' => 'add'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="bi bi-bar-chart-line"></i> Reports', ['controller' => 'Reports', 'action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
    </div>
</section>

<section class="ticker-card">
    <div class="ticker-track">
        <span>Smart Inventory keeps every office supply visible, every requisition traceable, and every stock movement under control.</span>
        <span>Approve requests, manage vendors, prevent low stock issues and keep the organization moving.</span>
    </div>
</section>

<section class="stat-grid">
    <?php foreach ($cards as $card): ?>
        <article class="stat-card stat-<?= h($card[3]) ?>">
            <i class="bi <?= h($card[2]) ?>"></i>
            <span><?= h($card[0]) ?></span>
            <strong><?= $this->Number->format($card[1]) ?></strong>
        </article>
    <?php endforeach; ?>
</section>

<section class="dashboard-charts">
    <div class="chart-card premium-glass">
        <div class="panel-title">
            <h2>Monthly Requests Graph</h2>
        </div>
        <canvas data-dashboard-chart data-label="Monthly Requests" data-labels="<?= h(implode(',', $monthlyRequestLabels)) ?>" data-values="<?= h(implode(',', $monthlyRequestValues)) ?>"></canvas>
    </div>
    <div class="chart-card premium-glass">
        <div class="panel-title">
            <h2>Vendor Statistics</h2>
        </div>
        <canvas data-dashboard-chart data-chart-type="doughnut" data-label="Vendor Items" data-labels="<?= h(implode(',', array_keys($vendorStats ?: ['No Vendors' => 0]))) ?>" data-values="<?= h(implode(',', array_values($vendorStats ?: ['No Vendors' => 0]))) ?>"></canvas>
    </div>
</section>

<section class="report-layout">
    <article class="content-panel report-card">
        <div class="panel-title">
            <h2>Top Requested Items</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Item Catalog</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topRequestedItems as $itemName => $quantity): ?>
                        <tr>
                            <td><?= h($itemName) ?></td>
                            <td><?= $this->Number->format($quantity) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($topRequestedItems === []): ?>
                        <tr><td colspan="2">No requested items yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </article>

    <article class="content-panel report-card">
        <div class="panel-title">
            <h2>Recent Activities</h2>
            <?= $this->Html->link('View Reports', ['controller' => 'Reports', 'action' => 'index'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
        <div class="request-timeline compact">
            <?php foreach ($recentRequisitions as $request): ?>
                <?php $status = strtolower((string)($request->status ?? 'pending')); ?>
                <article>
                    <span class="timeline-dot status-<?= h($status) ?>"></span>
                    <div>
                        <strong><?= h($request->staff->staff_name ?? 'Unknown Staff') ?></strong>
                        <p>Requested: <?= h($request->request_date ?? '-') ?></p>
                    </div>
                    <span class="status-badge status-<?= h($status) ?>"><?= h($request->status ?? 'Pending') ?></span>
                </article>
            <?php endforeach; ?>
        </div>
    </article>
</section>

<section class="content-panel">
    <div class="panel-title">
        <h2>Recent Request Activity</h2>
        <?= $this->Html->link('View All', ['controller' => 'Requisition', 'action' => 'index'], ['class' => 'btn btn-sm btn-primary']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Staff</th>
                    <th>Status</th>
                    <th>Required Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentRequisitions as $request): ?>
                    <?php $status = strtolower((string)($request->status ?? 'pending')); ?>
                    <tr>
                        <td><?= h($request->requisition_id) ?></td>
                        <td><?= h($request->staff->staff_name ?? '-') ?></td>
                        <td><span class="status-badge status-<?= h($status) ?>"><?= h($request->status ?? 'Pending') ?></span></td>
                        <td><?= h($request->required_date ?? '-') ?></td>
                        <td><?= $this->Html->link('Open', ['controller' => 'Requisition', 'action' => 'view', $request->requisition_id]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
