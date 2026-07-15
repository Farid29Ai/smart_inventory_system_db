<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StockTransactionFixture
 */
class StockTransactionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'stock_transaction';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'transaction_id' => 1,
                'item_id' => 1,
                'admin_id' => 1,
                'transaction_type' => 'Lorem ipsum dolor sit amet',
                'quantity' => 1,
                'transaction_date' => '2026-06-26 15:12:14',
                'remarks' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
