<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductionOrderTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductionOrderTable Test Case
 */
class ProductionOrderTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductionOrderTable
     */
    protected $ProductionOrder;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProductionOrder',
        'app.ProductFamilies',
        'app.Inspection',
        'app.Lot',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductionOrder') ? [] : ['className' => ProductionOrderTable::class];
        $this->ProductionOrder = $this->getTableLocator()->get('ProductionOrder', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductionOrder);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProductionOrderTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProductionOrderTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
