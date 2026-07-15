<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequisitionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequisitionTable Test Case
 */
class RequisitionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RequisitionTable
     */
    protected $Requisition;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Requisition',
        'app.Staffs',
        'app.Admins',
        'app.Item',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Requisition') ? [] : ['className' => RequisitionTable::class];
        $this->Requisition = $this->getTableLocator()->get('Requisition', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Requisition);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RequisitionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RequisitionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
