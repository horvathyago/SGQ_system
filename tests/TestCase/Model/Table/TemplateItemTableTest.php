<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TemplateItemTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TemplateItemTable Test Case
 */
class TemplateItemTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TemplateItemTable
     */
    protected $TemplateItem;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.TemplateItem',
        'app.ChecklistTemplateVersions',
        'app.ItemMasters',
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
        $config = $this->getTableLocator()->exists('TemplateItem') ? [] : ['className' => TemplateItemTable::class];
        $this->TemplateItem = $this->getTableLocator()->get('TemplateItem', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TemplateItem);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TemplateItemTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TemplateItemTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
