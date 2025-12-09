<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MrbActionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MrbActionTable Test Case
 */
class MrbActionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MrbActionTable
     */
    protected $MrbAction;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.MrbAction',
        'app.NonConformities',
        'app.Responsavels',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MrbAction') ? [] : ['className' => MrbActionTable::class];
        $this->MrbAction = $this->getTableLocator()->get('MrbAction', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MrbAction);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MrbActionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MrbActionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
