<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentTable Test Case
 */
class DocumentTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentTable
     */
    protected $Document;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Document',
        'app.Uploaders',
        'app.DocumentLink',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Document') ? [] : ['className' => DocumentTable::class];
        $this->Document = $this->getTableLocator()->get('Document', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Document);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\DocumentTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\DocumentTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
