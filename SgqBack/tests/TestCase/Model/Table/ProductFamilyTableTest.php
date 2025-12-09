<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductFamilyTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductFamilyTable Test Case
 */
class ProductFamilyTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductFamilyTable
     */
    protected $ProductFamily;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProductFamily',
        'app.Lot',
        'app.ProcessIndex',
        'app.ProductFamilyChecklist',
        'app.ProductionOrder',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductFamily') ? [] : ['className' => ProductFamilyTable::class];
        $this->ProductFamily = $this->getTableLocator()->get('ProductFamily', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductFamily);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProductFamilyTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProductFamilyTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
