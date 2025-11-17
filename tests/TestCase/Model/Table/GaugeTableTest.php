<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GaugeTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GaugeTable Test Case
 */
class GaugeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GaugeTable
     */
    protected $Gauge;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Gauge',
        'app.CalibrationRecord',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Gauge') ? [] : ['className' => GaugeTable::class];
        $this->Gauge = $this->getTableLocator()->get('Gauge', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Gauge);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\GaugeTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\GaugeTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
