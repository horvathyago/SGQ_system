<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CalibrationRecordTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CalibrationRecordTable Test Case
 */
class CalibrationRecordTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CalibrationRecordTable
     */
    protected $CalibrationRecord;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CalibrationRecord',
        'app.Gauges',
        'app.LaudoDocuments',
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
        $config = $this->getTableLocator()->exists('CalibrationRecord') ? [] : ['className' => CalibrationRecordTable::class];
        $this->CalibrationRecord = $this->getTableLocator()->get('CalibrationRecord', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CalibrationRecord);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\CalibrationRecordTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\CalibrationRecordTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
