<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AdminFixture
 */
class AdminFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'admin';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'admin_id' => 1,
                'admin_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'phone_no' => 'Lorem ipsum dolor ',
                'admin_level' => 'Lorem ipsum dolor sit amet',
                'profile_image' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2026-06-26 15:11:18',
            ],
        ];
        parent::init();
    }
}
