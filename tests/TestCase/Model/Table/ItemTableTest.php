<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemTable Test Case
 */
class ItemTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemTable
     */
    protected $Item;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Item',
        'app.Categories',
        'app.Vendors',
        'app.Requisition',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Item') ? [] : ['className' => ItemTable::class];
        $this->Item = $this->getTableLocator()->get('Item', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Item);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ItemTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ItemTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
