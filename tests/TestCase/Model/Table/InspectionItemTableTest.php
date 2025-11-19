<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InspectionItemTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InspectionItemTable Test Case
 */
class InspectionItemTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InspectionItemTable
     */
    protected $InspectionItem;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.InspectionItem',
        'app.Inspections',
        'app.ItemMasters',
        'app.TemplateItems',
        'app.CalibrationRecords',
        'app.NonConformity',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InspectionItem') ? [] : ['className' => InspectionItemTable::class];
        $this->InspectionItem = $this->getTableLocator()->get('InspectionItem', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->InspectionItem);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\InspectionItemTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\InspectionItemTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
