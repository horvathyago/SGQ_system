<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentLinkTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentLinkTable Test Case
 */
class DocumentLinkTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentLinkTable
     */
    protected $DocumentLink;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.DocumentLink',
        'app.Documents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DocumentLink') ? [] : ['className' => DocumentLinkTable::class];
        $this->DocumentLink = $this->getTableLocator()->get('DocumentLink', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocumentLink);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\DocumentLinkTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\DocumentLinkTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
