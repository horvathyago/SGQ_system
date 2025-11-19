<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChecklistTemplateVersionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChecklistTemplateVersionTable Test Case
 */
class ChecklistTemplateVersionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChecklistTemplateVersionTable
     */
    protected $ChecklistTemplateVersion;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ChecklistTemplateVersion',
        'app.ChecklistTemplates',
        'app.Inspection',
        'app.TemplateItem',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ChecklistTemplateVersion') ? [] : ['className' => ChecklistTemplateVersionTable::class];
        $this->ChecklistTemplateVersion = $this->getTableLocator()->get('ChecklistTemplateVersion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ChecklistTemplateVersion);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ChecklistTemplateVersionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ChecklistTemplateVersionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
