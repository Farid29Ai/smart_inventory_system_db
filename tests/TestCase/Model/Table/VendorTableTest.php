<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VendorTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VendorTable Test Case
 */
class VendorTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VendorTable
     */
    protected $Vendor;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Vendor',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Vendor') ? [] : ['className' => VendorTable::class];
        $this->Vendor = $this->getTableLocator()->get('Vendor', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Vendor);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\VendorTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
