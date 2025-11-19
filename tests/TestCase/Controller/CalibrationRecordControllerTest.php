<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\CalibrationRecordController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CalibrationRecordController Test Case
 *
 * @link \App\Controller\CalibrationRecordController
 */
class CalibrationRecordControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @link \App\Controller\CalibrationRecordController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\CalibrationRecordController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\CalibrationRecordController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\CalibrationRecordController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\CalibrationRecordController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
