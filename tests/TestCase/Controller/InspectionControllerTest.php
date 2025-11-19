<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\InspectionController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\InspectionController Test Case
 *
 * @link \App\Controller\InspectionController
 */
class InspectionControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Inspection',
        'app.ProductionOrders',
        'app.ChecklistTemplates',
        'app.ChecklistTemplateVersions',
        'app.Inspectors',
        'app.InspectionItem',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\InspectionController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\InspectionController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\InspectionController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\InspectionController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\InspectionController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
