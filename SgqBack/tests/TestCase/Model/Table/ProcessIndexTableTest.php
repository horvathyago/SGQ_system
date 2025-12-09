<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProcessIndexTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProcessIndexTable Test Case
 */
class ProcessIndexTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProcessIndexTable
     */
    protected $ProcessIndex;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProcessIndex',
        'app.ProductFamilies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProcessIndex') ? [] : ['className' => ProcessIndexTable::class];
        $this->ProcessIndex = $this->getTableLocator()->get('ProcessIndex', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProcessIndex);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProcessIndexTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProcessIndexTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
