<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RequisitionItemFixture
 */
class RequisitionItemFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'requisition_item';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'requisition_item_id' => 1,
                'requisition_id' => 1,
                'item_id' => 1,
                'quantity_requested' => 1,
                'quantity_approved' => 1,
            ],
        ];
        parent::init();
    }
}
