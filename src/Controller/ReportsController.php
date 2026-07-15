<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reports Controller
 *
 * Read-only admin reporting dashboard.
 */
class ReportsController extends AppController
{
    /**
     * Reports dashboard and exports.
     *
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $reportData = $this->buildReportData();
        $export = (string)$this->request->getQuery('export');

        if ($export === 'excel') {
            return $this->exportExcel($reportData);
        }

        if ($export === 'pdf') {
            return $this->exportPdf($reportData);
        }

        $this->set($reportData);
    }

    /**
     * Build report data from existing database tables.
     *
     * @return array<string, mixed>
     */
    private function buildReportData(): array
    {
        $requisitionsTable = $this->fetchTable('Requisition');
        $requisitionItemsTable = $this->fetchTable('RequisitionItem');
        $itemsTable = $this->fetchTable('Item');
        $vendorsTable = $this->fetchTable('Vendor');
        $stockTransactionsTable = $this->fetchTable('StockTransaction');
        $monthOptions = $this->monthOptions();
        $currentYear = (int)date('Y');
        $selectedMonth = (int)($this->request->getQuery('month') ?: date('n'));
        $selectedYear = (int)($this->request->getQuery('year') ?: $currentYear);

        if (!isset($monthOptions[$selectedMonth])) {
            $selectedMonth = (int)date('n');
        }
        if ($selectedYear < 2000 || $selectedYear > ($currentYear + 5)) {
            $selectedYear = $currentYear;
        }

        [$startDate, $endDate] = $this->dateRangeForMonth($selectedMonth, $selectedYear);
        $yearStartDate = sprintf('%04d-01-01', $selectedYear);
        $yearEndDate = sprintf('%04d-12-31', $selectedYear);
        $yearOptions = [];
        for ($year = $currentYear + 1; $year >= $currentYear - 6; $year--) {
            $yearOptions[$year] = (string)$year;
        }
        $yearOptions[$selectedYear] = (string)$selectedYear;
        krsort($yearOptions);

        $requisitions = $requisitionsTable->find()
            ->contain(['Staffs'])
            ->all();
        $items = $itemsTable->find()
            ->contain(['Vendors'])
            ->all();
        $requisitionItems = $requisitionItemsTable->find()
            ->contain(['Items'])
            ->all();

        $monthlyCounts = array_fill(1, 12, 0);
        $yearlyRequisitions = $requisitionsTable->find()
            ->select(['request_date'])
            ->where([
                'request_date >=' => $yearStartDate,
                'request_date <=' => $yearEndDate,
            ])
            ->all();
        foreach ($yearlyRequisitions as $request) {
            if ($request->request_date) {
                $monthlyCounts[(int)$request->request_date->format('n')]++;
            }
        }

        $filteredRequisitions = $requisitionsTable->find()
            ->contain(['Staffs'])
            ->where([
                'request_date >=' => $startDate,
                'request_date <=' => $endDate,
            ])
            ->all();

        $filteredReportRows = $requisitionItemsTable->find()
            ->contain(['Items', 'Requisitions' => ['Staffs']])
            ->innerJoinWith('Requisitions', function ($query) use ($startDate, $endDate) {
                return $query->where([
                    'Requisitions.request_date >=' => $startDate,
                    'Requisitions.request_date <=' => $endDate,
                ]);
            })
            ->orderByDesc('Requisitions.request_date')
            ->orderByDesc('RequisitionItem.requisition_item_id')
            ->all();

        $filteredSummary = [
            'total' => $filteredRequisitions->count(),
            'approved' => 0,
            'pending' => 0,
            'rejected' => 0,
        ];
        foreach ($filteredRequisitions as $request) {
            $normalisedStatus = $this->normaliseStatus((string)($request->status ?: 'Pending'));
            if (isset($filteredSummary[$normalisedStatus])) {
                $filteredSummary[$normalisedStatus]++;
            }
        }

        $statusCounts = [];
        foreach ($requisitions as $request) {
            $status = (string)($request->status ?: 'Pending');
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;
        }

        $topRequested = [];
        foreach ($filteredReportRows as $line) {
            $itemId = (int)$line->item_id;
            $itemName = (string)($line->item->item_name ?? ('Item #' . $itemId));
            if (!isset($topRequested[$itemId])) {
                $topRequested[$itemId] = [
                    'item_name' => $itemName,
                    'requests' => 0,
                    'quantity' => 0,
                ];
            }
            $topRequested[$itemId]['requests']++;
            $topRequested[$itemId]['quantity'] += (int)($line->quantity_requested ?? 0);
        }
        usort($topRequested, fn ($a, $b) => $b['requests'] <=> $a['requests']);
        $topRequested = array_slice($topRequested, 0, 5);

        $vendorStats = [];
        foreach ($items as $item) {
            $vendorName = (string)($item->vendor->vendor_name ?? 'Unassigned');
            $vendorStats[$vendorName] = ($vendorStats[$vendorName] ?? 0) + 1;
        }
        arsort($vendorStats);

        $lowStockCount = $itemsTable->find()
            ->where(['quantity_available <= minimum_stock'])
            ->count();
        $lowStockItems = $itemsTable->find()
            ->where(['quantity_available <= minimum_stock'])
            ->orderByAsc('quantity_available')
            ->limit(10)
            ->all();

        $recentActivity = $requisitionsTable->find()
            ->contain(['Staffs'])
            ->where([
                'request_date >=' => $startDate,
                'request_date <=' => $endDate,
            ])
            ->orderByDesc('request_date')
            ->orderByDesc('requisition_id')
            ->limit(8)
            ->all();

        $totalQuantity = 0;
        foreach ($items as $item) {
            $totalQuantity += (int)($item->quantity_available ?? 0);
        }

        $inventorySummary = [
            'totalItems' => $items->count(),
            'totalQuantity' => $totalQuantity,
            'lowStock' => $lowStockCount,
            'vendors' => $vendorsTable->find()->count(),
            'transactions' => $stockTransactionsTable->find()->count(),
            'requisitions' => $requisitions->count(),
        ];

        return [
            'inventorySummary' => $inventorySummary,
            'monthlyLabels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'monthlyValues' => array_values($monthlyCounts),
            'statusCounts' => $statusCounts,
            'topRequested' => $topRequested,
            'lowStockItems' => $lowStockItems,
            'vendorStats' => $vendorStats,
            'recentActivity' => $recentActivity,
            'monthOptions' => $monthOptions,
            'yearOptions' => $yearOptions,
            'reportFilter' => [
                'month' => $selectedMonth,
                'monthName' => $monthOptions[$selectedMonth],
                'year' => $selectedYear,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ],
            'filteredSummary' => $filteredSummary,
            'filteredReportRows' => $filteredReportRows,
        ];
    }

    /**
     * Month select options.
     *
     * @return array<int, string>
     */
    private function monthOptions(): array
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }

    /**
     * Build an inclusive date range for a month and year.
     *
     * @param int $month Selected month.
     * @param int $year Selected year.
     * @return array{0: string, 1: string}
     */
    private function dateRangeForMonth(int $month, int $year): array
    {
        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));

        return [$startDate, $endDate];
    }

    /**
     * Normalise requisition statuses for summary counters.
     *
     * @param string $status Status value.
     * @return string
     */
    private function normaliseStatus(string $status): string
    {
        $status = strtolower(trim($status));
        if (in_array($status, ['approved', 'complete', 'completed'], true)) {
            return 'approved';
        }
        if (in_array($status, ['rejected', 'declined'], true)) {
            return 'rejected';
        }

        return 'pending';
    }

    /**
     * Export report data in an Excel-compatible worksheet.
     *
     * @param array<string, mixed> $reportData Report data.
     * @return \Cake\Http\Response
     */
    private function exportExcel(array $reportData)
    {
        $rows = [
            ['Smart Inventory Report'],
            ['Month', $reportData['reportFilter']['monthName']],
            ['Year', $reportData['reportFilter']['year']],
            [],
            ['Filtered Requisition Report'],
            ['Request ID', 'Staff Name', 'Item Name', 'Quantity Requested', 'Quantity Approved', 'Status', 'Request Date', 'Approval Date'],
        ];

        foreach ($reportData['filteredReportRows'] as $line) {
            $request = $line->requisition;
            $rows[] = [
                $request->requisition_id ?? '-',
                $request->staff->staff_name ?? 'Unknown Staff',
                $line->item->item_name ?? 'Unknown Item',
                $line->quantity_requested ?? 0,
                $line->quantity_approved ?? '-',
                $request->status ?? 'Pending',
                $request->request_date ?? '-',
                $request->approval_date ?? '-',
            ];
        }

        $rows[] = [];
        $rows[] = ['Inventory Summary'];
        $rows[] = ['Metric', 'Value'];

        foreach ($reportData['inventorySummary'] as $label => $value) {
            $rows[] = [$label, $value];
        }

        $rows[] = [];
        $rows[] = ['Top Requested Items'];
        $rows[] = ['Item Catalog', 'Requests', 'Quantity'];
        foreach ($reportData['topRequested'] as $item) {
            $rows[] = [$item['item_name'], $item['requests'], $item['quantity']];
        }

        $body = implode("\n", array_map(fn ($row) => implode("\t", $row), $rows));

        return $this->response
            ->withType('application/vnd.ms-excel')
            ->withHeader('Content-Disposition', 'attachment; filename="smart-inventory-report.xls"')
            ->withStringBody($body);
    }

    /**
     * Export a professional PDF requisition report.
     *
     * @param array<string, mixed> $reportData Report data.
     * @return \Cake\Http\Response
     */
    private function exportPdf(array $reportData)
    {
        $filter = $reportData['reportFilter'];
        $summary = $reportData['filteredSummary'];
        $rows = [];

        foreach ($reportData['filteredReportRows'] as $line) {
            $request = $line->requisition;
            $rows[] = [
                'request_id' => (string)($request->requisition_id ?? '-'),
                'staff' => (string)($request->staff->staff_name ?? 'Unknown Staff'),
                'item' => (string)($line->item->item_name ?? 'Unknown Item'),
                'qty_requested' => (string)($line->quantity_requested ?? 0),
                'qty_approved' => $line->quantity_approved === null ? '0' : (string)$line->quantity_approved,
                'status' => (string)($request->status ?? 'Pending'),
                'request_date' => $this->pdfDate($request->request_date ?? null),
                'approval_date' => $this->pdfDate($request->approval_date ?? null),
            ];
        }

        $pages = [];
        $firstPageRows = 12;
        $otherPageRows = 18;
        if ($rows === []) {
            $pages[] = [];
        } else {
            $pages[] = array_slice($rows, 0, $firstPageRows);
            $remainingRows = array_slice($rows, $firstPageRows);
            foreach (array_chunk($remainingRows, $otherPageRows) as $chunk) {
                $pages[] = $chunk;
            }
        }

        $pageCount = count($pages);
        $generatedAt = date('d M Y, h:i A');
        $objects = [
            "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj",
        ];

        $pageObjectNumbers = [];
        $contentObjectNumbers = [];
        $nextObjectNumber = 3;
        foreach ($pages as $pageIndex => $pageRows) {
            $pageObjectNumbers[] = $nextObjectNumber++;
            $contentObjectNumbers[] = $nextObjectNumber++;
        }

        $objects[] = '2 0 obj << /Type /Pages /Kids [' . implode(' ', array_map(fn ($number) => $number . ' 0 R', $pageObjectNumbers)) . '] /Count ' . $pageCount . ' >> endobj';
        $fontRegularObjectNumber = $nextObjectNumber++;
        $fontBoldObjectNumber = $nextObjectNumber++;

        foreach ($pages as $pageIndex => $pageRows) {
            $content = $this->buildReportPdfPage(
                $reportData,
                $pageRows,
                $pageIndex + 1,
                $pageCount,
                $generatedAt,
                $pageIndex === 0
            );
            $pageObjectNumber = $pageObjectNumbers[$pageIndex];
            $contentObjectNumber = $contentObjectNumbers[$pageIndex];
            $objects[] = $pageObjectNumber . ' 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 ' . $fontRegularObjectNumber . ' 0 R /F2 ' . $fontBoldObjectNumber . ' 0 R >> >> /Contents ' . $contentObjectNumber . ' 0 R >> endobj';
            $objects[] = $contentObjectNumber . ' 0 obj << /Length ' . strlen($content) . " >> stream\n" . $content . "\nendstream endobj";
        }

        $objects[] = $fontRegularObjectNumber . ' 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj';
        $objects[] = $fontBoldObjectNumber . ' 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >> endobj';

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n0000000000 65535 f \n";
        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= str_pad((string)$offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }
        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref . "\n%%EOF";

        $filename = sprintf(
            'smart_inventory_requisition_report_%04d_%02d.pdf',
            (int)$filter['year'],
            (int)$filter['month']
        );

        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->withStringBody($pdf);
    }

    /**
     * Build one PDF page content stream.
     *
     * @param array<string, mixed> $reportData Report data.
     * @param array<int, array<string, string>> $rows Rows for the page.
     * @param int $pageNumber Current page number.
     * @param int $pageCount Total page count.
     * @param string $generatedAt Generated date text.
     * @param bool $includeSummary Whether summary cards should be rendered.
     * @return string
     */
    private function buildReportPdfPage(
        array $reportData,
        array $rows,
        int $pageNumber,
        int $pageCount,
        string $generatedAt,
        bool $includeSummary
    ): string {
        $filter = $reportData['reportFilter'];
        $summary = $reportData['filteredSummary'];
        $content = '';

        $content .= $this->pdfFillRect(0, 0, 595, 842, [1, 1, 1]);
        $content .= $this->pdfFillRect(32, 781, 34, 34, [0.145, 0.388, 0.922]);
        $content .= $this->pdfText(43, 792, 'SI', 13, 'F2', [1, 1, 1]);
        $content .= $this->pdfText(76, 802, 'SmartInventory', 21, 'F2', [0.058, 0.09, 0.165]);
        $content .= $this->pdfText(77, 786, 'SMART INVENTORY SYSTEM', 9, 'F1', [0.278, 0.333, 0.412]);
        $content .= $this->pdfTextRight(563, 800, 'REQUISITION REPORT', 20, 'F2', [0.058, 0.09, 0.165]);
        $content .= $this->pdfTextRight(563, 780, 'Month: ' . (string)$filter['monthName'], 11, 'F1', [0.2, 0.254, 0.333]);
        $content .= $this->pdfTextRight(563, 765, 'Year: ' . (string)$filter['year'], 11, 'F1', [0.2, 0.254, 0.333]);
        $content .= $this->pdfFillRect(32, 746, 531, 3, [0.145, 0.388, 0.922]);

        $tableY = 682;
        if ($includeSummary) {
            $content .= $this->pdfSectionTitle(32, 718, 'SUMMARY');
            $cards = [
                ['Total Requests', (string)$summary['total'], [0.145, 0.388, 0.922]],
                ['Total Approved', (string)$summary['approved'], [0.086, 0.506, 0.235]],
                ['Total Pending', (string)$summary['pending'], [0.851, 0.325, 0.098]],
                ['Total Rejected', (string)$summary['rejected'], [0.725, 0.11, 0.11]],
            ];
            $x = 32;
            foreach ($cards as $card) {
                $content .= $this->pdfSummaryCard($x, 646, 124, 52, $card[0], $card[1], $card[2]);
                $x += 135;
            }
            $content .= $this->pdfSectionTitle(32, 609, 'REQUISITION LIST');
            $tableY = 585;
        } else {
            $content .= $this->pdfSectionTitle(32, 714, 'REQUISITION LIST (CONTINUED)');
            $tableY = 690;
        }

        if ($rows === []) {
            $content .= $this->pdfStrokeRect(32, $tableY - 78, 531, 54, [0.859, 0.89, 0.937]);
            $content .= $this->pdfFillRect(33, $tableY - 77, 529, 52, [0.972, 0.98, 0.992]);
            $content .= $this->pdfText(129, $tableY - 50, 'No requisition records found for this month and year.', 12, 'F2', [0.278, 0.333, 0.412]);
        } else {
            $content .= $this->pdfReportTable($rows, 32, $tableY);
        }

        $content .= $this->pdfFillRect(32, 55, 531, 2, [0.145, 0.388, 0.922]);
        $content .= $this->pdfText(32, 38, 'Generated by SmartInventory System', 9, 'F1', [0.278, 0.333, 0.412]);
        $content .= $this->pdfText(400, 38, 'Generated on: ' . $generatedAt, 9, 'F1', [0.278, 0.333, 0.412]);
        $content .= $this->pdfText(501, 25, 'Page ' . $pageNumber . ' of ' . $pageCount, 9, 'F1', [0.278, 0.333, 0.412]);

        return $content;
    }

    /**
     * Draw report table.
     *
     * @param array<int, array<string, string>> $rows Report rows.
     * @param float $x X coordinate.
     * @param float $y Header top coordinate.
     * @return string
     */
    private function pdfReportTable(array $rows, float $x, float $y): string
    {
        $columns = [
            ['Request ID', 48, 'request_id', 'left'],
            ['Staff Name', 78, 'staff', 'left'],
            ['Item Name', 82, 'item', 'left'],
            ['Qty Req', 42, 'qty_requested', 'center'],
            ['Qty Appr', 48, 'qty_approved', 'center'],
            ['Status', 58, 'status', 'center'],
            ['Request Date', 68, 'request_date', 'center'],
            ['Approval Date', 111, 'approval_date', 'center'],
        ];
        $content = '';
        $rowHeight = 32;
        $headerHeight = 28;
        $tableWidth = 535;

        $content .= $this->pdfFillRect($x, $y - $headerHeight, $tableWidth, $headerHeight, [0.114, 0.302, 0.753]);
        $content .= $this->pdfStrokeRect($x, $y - $headerHeight, $tableWidth, $headerHeight, [0.578, 0.773, 0.992]);
        $cursorX = $x;
        foreach ($columns as $column) {
            $content .= $this->pdfText($cursorX + 5, $y - 18, $column[0], 7.5, 'F2', [1, 1, 1]);
            $cursorX += $column[1];
        }

        $currentY = $y - $headerHeight;
        foreach ($rows as $index => $row) {
            $currentY -= $rowHeight;
            $content .= $this->pdfFillRect($x, $currentY, $tableWidth, $rowHeight, $index % 2 === 0 ? [1, 1, 1] : [0.972, 0.98, 0.992]);
            $content .= $this->pdfStrokeRect($x, $currentY, $tableWidth, $rowHeight, [0.859, 0.89, 0.937]);
            $cursorX = $x;
            foreach ($columns as $column) {
                $width = (float)$column[1];
                $key = (string)$column[2];
                $align = (string)$column[3];
                $value = $row[$key] ?? '-';
                if ($key === 'status') {
                    $content .= $this->pdfStatusBadge($cursorX + 5, $currentY + 10, $this->truncatePdfText($value, 9));
                } else {
                    $maxChars = max(4, (int)floor(($width - 8) / 4.8));
                    $text = $this->truncatePdfText($value, $maxChars);
                    $textX = $align === 'center' ? $cursorX + ($width / 2) - (strlen($text) * 2.15) : $cursorX + 5;
                    $content .= $this->pdfText($textX, $currentY + 12, $text, 8.5, $key === 'request_id' ? 'F2' : 'F1', [0.058, 0.09, 0.165]);
                }
                $cursorX += $width;
            }
        }

        return $content;
    }

    /**
     * Draw a summary card.
     *
     * @param float $x X coordinate.
     * @param float $y Y coordinate.
     * @param float $width Width.
     * @param float $height Height.
     * @param string $label Card label.
     * @param string $number Card number.
     * @param array<int, float> $accent RGB accent.
     * @return string
     */
    private function pdfSummaryCard(float $x, float $y, float $width, float $height, string $label, string $number, array $accent): string
    {
        $light = [
            min(1, $accent[0] + .78),
            min(1, $accent[1] + .48),
            min(1, $accent[2] + .06),
        ];

        $content = $this->pdfFillRect($x, $y, $width, $height, [1, 1, 1]);
        $content .= $this->pdfStrokeRect($x, $y, $width, $height, [0.859, 0.89, 0.937]);
        $content .= $this->pdfFillRect($x + 12, $y + 24, 18, 18, $light);
        $content .= $this->pdfFillRect($x + 18, $y + 30, 6, 6, $accent);
        $content .= $this->pdfText($x + 40, $y + 27, $number, 19, 'F2', $accent);
        $content .= $this->pdfText($x + 40, $y + 13, $label, 8.8, 'F1', [0.2, 0.254, 0.333]);

        return $content;
    }

    /**
     * Draw a status badge.
     *
     * @param float $x X coordinate.
     * @param float $y Y coordinate.
     * @param string $status Status label.
     * @return string
     */
    private function pdfStatusBadge(float $x, float $y, string $status): string
    {
        $normalised = $this->normaliseStatus($status);
        $styles = [
            'approved' => [[0.941, 0.992, 0.956], [0.086, 0.506, 0.235]],
            'rejected' => [[0.996, 0.949, 0.949], [0.725, 0.11, 0.11]],
            'pending' => [[1, 0.984, 0.922], [0.706, 0.306, 0.035]],
        ];
        [$background, $textColor] = $styles[$normalised] ?? $styles['pending'];
        $content = $this->pdfFillRect($x, $y, 48, 14, $background);
        $content .= $this->pdfStrokeRect($x, $y, 48, 14, $textColor);
        $content .= $this->pdfText($x + 5, $y + 4, ucfirst($normalised), 7.5, 'F2', $textColor);

        return $content;
    }

    /**
     * Draw a PDF section title.
     *
     * @param float $x X coordinate.
     * @param float $y Y coordinate.
     * @param string $title Title.
     * @return string
     */
    private function pdfSectionTitle(float $x, float $y, string $title): string
    {
        return $this->pdfFillRect($x, $y - 3, 4, 14, [0.231, 0.51, 0.965])
            . $this->pdfText($x + 10, $y, $title, 14, 'F2', [0.114, 0.302, 0.753]);
    }

    /**
     * Draw escaped PDF text.
     *
     * @param float $x X coordinate.
     * @param float $y Y coordinate.
     * @param string $text Text.
     * @param float $size Font size.
     * @param string $font Font resource.
     * @param array<int, float> $color RGB color.
     * @return string
     */
    private function pdfText(float $x, float $y, string $text, float $size = 10, string $font = 'F1', array $color = [0, 0, 0]): string
    {
        return sprintf(
            "%.3F %.3F %.3F rg BT /%s %.2F Tf %.2F %.2F Td (%s) Tj ET\n",
            $color[0],
            $color[1],
            $color[2],
            $font,
            $size,
            $x,
            $y,
            $this->escapePdfText($text)
        );
    }

    /**
     * Draw right-aligned PDF text using a conservative Helvetica width estimate.
     *
     * @param float $rightX Right edge coordinate.
     * @param float $y Y coordinate.
     * @param string $text Text.
     * @param float $size Font size.
     * @param string $font Font resource.
     * @param array<int, float> $color RGB color.
     * @return string
     */
    private function pdfTextRight(float $rightX, float $y, string $text, float $size = 10, string $font = 'F1', array $color = [0, 0, 0]): string
    {
        $estimatedWidth = strlen($text) * $size * 0.55;
        $x = max(300, $rightX - $estimatedWidth);

        return $this->pdfText($x, $y, $text, $size, $font, $color);
    }

    /**
     * Draw filled rectangle.
     *
     * @param float $x X coordinate.
     * @param float $y Y coordinate.
     * @param float $width Width.
     * @param float $height Height.
     * @param array<int, float> $color RGB color.
     * @return string
     */
    private function pdfFillRect(float $x, float $y, float $width, float $height, array $color): string
    {
        return sprintf("%.3F %.3F %.3F rg %.2F %.2F %.2F %.2F re f\n", $color[0], $color[1], $color[2], $x, $y, $width, $height);
    }

    /**
     * Draw stroked rectangle.
     *
     * @param float $x X coordinate.
     * @param float $y Y coordinate.
     * @param float $width Width.
     * @param float $height Height.
     * @param array<int, float> $color RGB color.
     * @return string
     */
    private function pdfStrokeRect(float $x, float $y, float $width, float $height, array $color): string
    {
        return sprintf("%.3F %.3F %.3F RG 0.75 w %.2F %.2F %.2F %.2F re S\n", $color[0], $color[1], $color[2], $x, $y, $width, $height);
    }

    /**
     * Format dates safely for PDF output.
     *
     * @param mixed $value Date value.
     * @return string
     */
    private function pdfDate(mixed $value): string
    {
        if ($value && is_object($value) && method_exists($value, 'format')) {
            return $value->format('d M Y');
        }
        if ($value) {
            $timestamp = strtotime((string)$value);
            if ($timestamp !== false) {
                return date('d M Y', $timestamp);
            }
        }

        return '-';
    }

    /**
     * Truncate text for fixed-width PDF cells.
     *
     * @param string $text Text.
     * @param int $length Max length.
     * @return string
     */
    private function truncatePdfText(string $text, int $length): string
    {
        $cleanText = trim(preg_replace('/\s+/', ' ', $text) ?? $text);
        if (strlen($cleanText) <= $length) {
            return $cleanText;
        }

        return substr($cleanText, 0, max(1, $length - 3)) . '...';
    }

    /**
     * Escape text for PDF literal strings.
     *
     * @param string $text Text.
     * @return string
     */
    private function escapePdfText(string $text): string
    {
        $text = str_replace(["\r", "\n", "\t"], ' ', $text);
        $text = preg_replace('/[^\x20-\x7E]/', '', $text) ?? $text;

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }
}
