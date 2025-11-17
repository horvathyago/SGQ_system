<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistTemplateTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistTemplateTable Test Case
 */
class ChecklistTemplateTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistTemplateTable
     */
    protected $ChecklistTemplate;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ChecklistTemplate',
        'app.ChecklistTemplateVersion',
        'app.Inspection',
        'app.ProductFamilyChecklist',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ChecklistTemplate') ? [] : ['className' => ChecklistTemplateTable::class];
        $this->ChecklistTemplate = $this->getTableLocator()->get('ChecklistTemplate', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ChecklistTemplate);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ChecklistTemplateTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
