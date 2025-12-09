<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InspectionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InspectionTable Test Case
 */
class InspectionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InspectionTable
     */
    protected $Inspection;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Inspection',
        'app.ProductionOrders',
        'app.ChecklistTemplates',
        'app.ChecklistTemplateVersions',
        'app.Inspectors',
        'app.InspectionItem',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Inspection') ? [] : ['className' => InspectionTable::class];
        $this->Inspection = $this->getTableLocator()->get('Inspection', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Inspection);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\InspectionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\InspectionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
