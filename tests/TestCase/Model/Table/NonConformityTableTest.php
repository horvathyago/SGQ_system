<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NonConformityTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NonConformityTable Test Case
 */
class NonConformityTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NonConformityTable
     */
    protected $NonConformity;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.NonConformity',
        'app.InspectionItems',
        'app.Responsavels',
        'app.MrbAction',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NonConformity') ? [] : ['className' => NonConformityTable::class];
        $this->NonConformity = $this->getTableLocator()->get('NonConformity', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->NonConformity);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\NonConformityTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\NonConformityTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
