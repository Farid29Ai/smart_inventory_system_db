<?php
/**
 * @var \App\View\AppView $this
 * @var array $stats
 * @var iterable<\App\Model\Entity\Requisition> $recentRequisitions
 * @var array $monthlyRequestLabels
 * @var array $monthlyRequestValues
 */
$this->assign('title', 'Staff Dashboard');
$cards = [
    ['My Requisitions', $stats['myRequisitions'], 'bi-clipboard-data', 'blue'],
    ['Pending Requests', $stats['pending'], 'bi-hourglass-split', 'warning'],
    ['Approved Requests', $stats['approved'], 'bi-check2-circle', 'success'],
    ['Rejected Requests', $stats['rejected'], 'bi-x-circle', 'danger'],
    ['Available Item Catalog', $stats['items'], 'bi-box-seam', 'cyan'],
    ['Recent Requests', count($recentRequisitions), 'bi-clock-history', 'purple'],
];
?>
<section class="dashboard-head">
    <div>
        <p class="eyebrow">Staff Dashboard</p>
        <h1>Office Supplies Request Hub</h1>
        <p>Create requisitions, monitor request status and browse available office supplies quickly.</p>
    </div>
    <div class="dashboard-actions">
        <?= $this->Html->link('<i class="bi bi-plus-circle"></i> Quick Request', ['controller' => 'Requisition', 'action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="bi bi-box-seam"></i> Browse Item Catalog', ['controller' => 'Item', 'action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
    </div>
</section>

<section class="ticker-card">
    <div class="ticker-track">
        <span>Request office supplies faster, track every status clearly, and keep department operations running smoothly.</span>
        <span>Smart Inventory gives staff a clean, modern and reliable requisition workspace.</span>
    </div>
</section>

<section class="stat-grid staff-stats">
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
            <h2>My Request Trend</h2>
        </div>
        <canvas data-dashboard-chart data-label="Requests" data-labels="<?= h(implode(',', $monthlyRequestLabels)) ?>" data-values="<?= h(implode(',', $monthlyRequestValues)) ?>"></canvas>
    </div>
    <div class="chart-card premium-glass">
        <div class="panel-title">
            <h2>Status Breakdown</h2>
        </div>
        <canvas data-dashboard-chart data-chart-type="doughnut" data-label="Status" data-labels="Pending,Approved,Rejected" data-values="<?= h($stats['pending']) ?>,<?= h($stats['approved']) ?>,<?= h($stats['rejected']) ?>"></canvas>
    </div>
</section>

<section class="content-panel">
    <div class="panel-title">
        <h2>My Recent Requests</h2>
        <?= $this->Html->link('View History', ['controller' => 'Requisition', 'action' => 'index'], ['class' => 'btn btn-sm btn-primary']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Purpose</th>
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
                        <td><?= h($request->purpose ?? '-') ?></td>
                        <td><span class="status-badge status-<?= h($status) ?>"><?= h($request->status ?? 'Pending') ?></span></td>
                        <td><?= h($request->required_date ?? '-') ?></td>
                        <td><?= $this->Html->link('Open', ['controller' => 'Requisition', 'action' => 'view', $request->requisition_id]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
