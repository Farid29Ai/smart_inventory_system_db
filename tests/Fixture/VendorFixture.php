<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VendorFixture
 */
class VendorFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'vendor';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'vendor_id' => 1,
                'vendor_name' => 'Lorem ipsum dolor sit amet',
                'contact_person' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
