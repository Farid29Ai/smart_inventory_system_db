<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RequisitionItemTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RequisitionItemTable Test Case
 */
class RequisitionItemTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RequisitionItemTable
     */
    protected $RequisitionItem;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RequisitionItem',
        'app.Requisitions',
        'app.Items',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RequisitionItem') ? [] : ['className' => RequisitionItemTable::class];
        $this->RequisitionItem = $this->getTableLocator()->get('RequisitionItem', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RequisitionItem);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RequisitionItemTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RequisitionItemTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
