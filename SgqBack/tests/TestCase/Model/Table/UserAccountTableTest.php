<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserAccountTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserAccountTable Test Case
 */
class UserAccountTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserAccountTable
     */
    protected $UserAccount;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.UserAccount',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserAccount') ? [] : ['className' => UserAccountTable::class];
        $this->UserAccount = $this->getTableLocator()->get('UserAccount', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserAccount);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\UserAccountTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\UserAccountTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
