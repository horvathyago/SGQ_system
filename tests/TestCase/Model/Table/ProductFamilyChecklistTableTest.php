<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductFamilyChecklistTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductFamilyChecklistTable Test Case
 */
class ProductFamilyChecklistTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductFamilyChecklistTable
     */
    protected $ProductFamilyChecklist;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProductFamilyChecklist',
        'app.ProductFamilies',
        'app.ChecklistTemplates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductFamilyChecklist') ? [] : ['className' => ProductFamilyChecklistTable::class];
        $this->ProductFamilyChecklist = $this->getTableLocator()->get('ProductFamilyChecklist', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductFamilyChecklist);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProductFamilyChecklistTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProductFamilyChecklistTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
