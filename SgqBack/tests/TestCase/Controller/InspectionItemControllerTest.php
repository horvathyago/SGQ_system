<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\InspectionItemController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\InspectionItemController Test Case
 *
 * @link \App\Controller\InspectionItemController
 */
class InspectionItemControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.InspectionItem',
        'app.Inspections',
        'app.ItemMasters',
        'app.TemplateItems',
        'app.CalibrationRecords',
        'app.NonConformity',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\InspectionItemController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\InspectionItemController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\InspectionItemController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\InspectionItemController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\InspectionItemController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
