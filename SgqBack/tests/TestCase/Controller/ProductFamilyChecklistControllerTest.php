<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProductFamilyChecklistController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProductFamilyChecklistController Test Case
 *
 * @link \App\Controller\ProductFamilyChecklistController
 */
class ProductFamilyChecklistControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProductFamilyChecklist',
        'app.ProductFamilies',
        'app.ChecklistTemplates',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\ProductFamilyChecklistController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\ProductFamilyChecklistController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\ProductFamilyChecklistController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\ProductFamilyChecklistController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\ProductFamilyChecklistController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
