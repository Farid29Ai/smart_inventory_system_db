<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StaffFixture
 */
class StaffFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'staff';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'staff_id' => 1,
                'staff_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ipsum dolor ',
                'department' => 'Lorem ipsum dolor sit amet',
                'position' => 'Lorem ipsum dolor sit amet',
                'profile_image' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2026-06-26 15:12:01',
            ],
        ];
        parent::init();
    }
}
