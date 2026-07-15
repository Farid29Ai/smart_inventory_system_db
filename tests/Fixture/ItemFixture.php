<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemFixture
 */
class ItemFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'item';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'item_id' => 1,
                'item_name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'category_id' => 1,
                'vendor_id' => 1,
                'quantity_available' => 1,
                'minimum_stock' => 1,
                'unit' => 'Lorem ipsum dolor sit amet',
                'item_image' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2026-06-26 15:11:32',
                'updated_at' => '2026-06-26 15:11:32',
            ],
        ];
        parent::init();
    }
}
