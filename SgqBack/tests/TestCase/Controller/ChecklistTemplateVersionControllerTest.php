<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ChecklistTemplateVersionController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ChecklistTemplateVersionController Test Case
 *
 * @link \App\Controller\ChecklistTemplateVersionController
 */
class ChecklistTemplateVersionControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ChecklistTemplateVersion',
        'app.ChecklistTemplates',
        'app.Inspection',
        'app.TemplateItem',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\ChecklistTemplateVersionController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\ChecklistTemplateVersionController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\ChecklistTemplateVersionController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\ChecklistTemplateVersionController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\ChecklistTemplateVersionController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
