<?php
/**
 * @var \App\View\AppView $this
 * @var array $inventorySummary
 * @var array $monthlyLabels
 * @var array $monthlyValues
 * @var array $statusCounts
 * @var array $topRequested
 * @var iterable<\App\Model\Entity\Item> $lowStockItems
 * @var array $vendorStats
 * @var iterable<\App\Model\Entity\Requisition> $recentActivity
 * @var array $monthOptions
 * @var array $yearOptions
 * @var array $reportFilter
 * @var array $filteredSummary
 * @var iterable<\App\Model\Entity\RequisitionItem> $filteredReportRows
 */
$this->assign('title', 'Reports');
$filterQuery = [
    'month' => $reportFilter['month'],
    'year' => $reportFilter['year'],
];
$filteredSummaryCards = [
    ['Total Requests', $filteredSummary['total'], 'bi-clipboard-data', 'blue'],
    ['Total Approved', $filteredSummary['approved'], 'bi-check2-circle', 'success'],
    ['Total Pending', $filteredSummary['pending'], 'bi-hourglass-split', 'warning'],
    ['Total Rejected', $filteredSummary['rejected'], 'bi-x-circle', 'danger'],
];
$summaryCards = [
    ['Total Item Catalog', $inventorySummary['totalItems'], 'bi-box-seam', 'blue'],
    ['Total Stock Quantity', $inventorySummary['totalQuantity'], 'bi-stack', 'cyan'],
    ['Low Stock', $inventorySummary['lowStock'], 'bi-exclamation-triangle', 'danger'],
    ['Vendors', $inventorySummary['vendors'], 'bi-building', 'purple'],
    ['Stock Transactions', $inventorySummary['transactions'], 'bi-arrow-left-right', 'success'],
    ['Requisitions', $inventorySummary['requisitions'], 'bi-clipboard-check', 'warning'],
];
?>
<section class="dashboard-head">
    <div>
        <p class="eyebrow">Admin Reports</p>
        <h1>Reports & Analytics Dashboard</h1>
        <p>Monthly requisitions, inventory health, requested item trends, vendors, stock alerts and activity from live database records.</p>
    </div>
    <div class="dashboard-actions">
        <?= $this->Html->link('<i class="bi bi-file-earmark-pdf"></i> Export PDF', ['action' => 'index', '?' => $filterQuery + ['export' => 'pdf']], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="bi bi-file-earmark-spreadsheet"></i> Export Excel', ['action' => 'index', '?' => $filterQuery + ['export' => 'excel']], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
        <button type="button" class="btn btn-ghost" onclick="window.print()"><i class="bi bi-printer"></i> Print Report</button>
    </div>
</section>

<section class="content-panel report-filter-card">
    <div class="panel-title">
        <div>
            <h2>Admin Requisition Report Filter</h2>
            <p>Showing requisition records for <?= h($reportFilter['monthName']) ?> <?= h((string)$reportFilter['year']) ?>.</p>
        </div>
    </div>
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'report-filter-form']) ?>
        <div class="report-filter-grid">
            <?= $this->Form->control('month', [
                'label' => 'Select Month',
                'options' => $monthOptions,
                'value' => $reportFilter['month'],
                'class' => 'form-select',
            ]) ?>
            <?= $this->Form->control('year', [
                'label' => 'Select Year',
                'options' => $yearOptions,
                'value' => $reportFilter['year'],
                'class' => 'form-select',
            ]) ?>
            <div class="report-filter-actions">
                <?= $this->Form->button('<i class="bi bi-search"></i> Search', ['class' => 'btn btn-primary', 'escapeTitle' => false]) ?>
                <?= $this->Html->link('<i class="bi bi-arrow-clockwise"></i> Reset', ['action' => 'index'], ['class' => 'btn btn-ghost', 'escape' => false]) ?>
                <?= $this->Html->link('<i class="bi bi-file-earmark-pdf"></i> Export PDF', ['action' => 'index', '?' => $filterQuery + ['export' => 'pdf']], ['class' => 'btn btn-ghost export-pdf-btn', 'escape' => false]) ?>
            </div>
        </div>
    <?= $this->Form->end() ?>
</section>

<section class="stat-grid reports-grid filtered-report-grid">
    <?php foreach ($filteredSummaryCards as $card): ?>
        <article class="stat-card stat-<?= h($card[3]) ?>">
            <i class="bi <?= h($card[2]) ?>"></i>
            <span><?= h($card[0]) ?></span>
            <strong><?= $this->Number->format($card[1]) ?></strong>
        </article>
    <?php endforeach; ?>
</section>

<section class="stat-grid reports-grid">
    <?php foreach ($summaryCards as $card): ?>
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
            <h2>Monthly Requisition Report <?= h((string)$reportFilter['year']) ?></h2>
        </div>
        <canvas data-dashboard-chart data-label="Monthly Requests" data-labels="<?= h(implode(',', $monthlyLabels)) ?>" data-values="<?= h(implode(',', $monthlyValues)) ?>"></canvas>
    </div>
    <div class="chart-card premium-glass">
        <div class="panel-title">
            <h2>Vendor Statistics</h2>
        </div>
        <canvas data-dashboard-chart data-chart-type="doughnut" data-label="Vendor Items" data-labels="<?= h(implode(',', array_keys($vendorStats ?: ['No Vendors' => 0]))) ?>" data-values="<?= h(implode(',', array_values($vendorStats ?: ['No Vendors' => 0]))) ?>"></canvas>
    </div>
</section>

<section class="content-panel requisition-filter-table">
    <div class="panel-title">
        <div>
            <h2>Filtered Requisition Records</h2>
            <p><?= h($reportFilter['monthName']) ?> <?= h((string)$reportFilter['year']) ?> requisition item details.</p>
        </div>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Staff Name</th>
                    <th>Item Name</th>
                    <th>Quantity Requested</th>
                    <th>Quantity Approved</th>
                    <th>Status</th>
                    <th>Request Date</th>
                    <th>Approval Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filteredReportRows as $line): ?>
                    <?php
                    $request = $line->requisition;
                    $status = strtolower((string)($request->status ?? 'pending'));
                    ?>
                    <tr>
                        <td><?= h($request->requisition_id ?? '-') ?></td>
                        <td><?= h($request->staff->staff_name ?? 'Unknown Staff') ?></td>
                        <td><?= h($line->item->item_name ?? 'Unknown Item') ?></td>
                        <td><?= $this->Number->format($line->quantity_requested ?? 0) ?></td>
                        <td><?= $line->quantity_approved === null ? '-' : $this->Number->format($line->quantity_approved) ?></td>
                        <td><span class="status-badge status-<?= h($status) ?>"><?= h($request->status ?? 'Pending') ?></span></td>
                        <td><?= h($request->request_date ?? '-') ?></td>
                        <td><?= h($request->approval_date ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($filteredReportRows->count() === 0): ?>
                    <tr>
                        <td colspan="8">No requisition records found for the selected month and year.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
                        <th>Request Count</th>
                        <th>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($topRequested as $item): ?>
                        <tr>
                            <td><?= h($item['item_name']) ?></td>
                            <td><?= $this->Number->format($item['requests']) ?></td>
                            <td><?= $this->Number->format($item['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($topRequested === []): ?>
                        <tr><td colspan="3">No requested items yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </article>

    <article class="content-panel report-card">
        <div class="panel-title">
            <h2>Low Stock Report</h2>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Item Catalog</th>
                        <th>Available</th>
                        <th>Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lowStockItems as $itemEntity): ?>
                        <tr>
                            <td><?= h($itemEntity->item_name) ?></td>
                            <td><?= $this->Number->format($itemEntity->quantity_available ?? 0) ?></td>
                            <td><?= $this->Number->format($itemEntity->minimum_stock ?? 0) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </article>
</section>

<section class="content-panel">
    <div class="panel-title">
        <h2>Recent Request Activity</h2>
        <?= $this->Html->link('View All Requests', ['controller' => 'Requisition', 'action' => 'index'], ['class' => 'btn btn-sm btn-primary']) ?>
    </div>
    <div class="request-timeline">
        <?php foreach ($recentActivity as $request): ?>
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
</section>
