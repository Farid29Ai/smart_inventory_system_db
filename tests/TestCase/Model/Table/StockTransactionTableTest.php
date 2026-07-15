<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StockTransactionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StockTransactionTable Test Case
 */
class StockTransactionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StockTransactionTable
     */
    protected $StockTransaction;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.StockTransaction',
        'app.Items',
        'app.Admins',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('StockTransaction') ? [] : ['className' => StockTransactionTable::class];
        $this->StockTransaction = $this->getTableLocator()->get('StockTransaction', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->StockTransaction);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\StockTransactionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\StockTransactionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
