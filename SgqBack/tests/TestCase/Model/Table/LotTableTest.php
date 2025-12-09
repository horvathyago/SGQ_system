<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LotTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LotTable Test Case
 */
class LotTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LotTable
     */
    protected $Lot;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Lot',
        'app.ProductFamilies',
        'app.ProductionOrders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Lot') ? [] : ['className' => LotTable::class];
        $this->Lot = $this->getTableLocator()->get('Lot', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Lot);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\LotTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\LotTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
