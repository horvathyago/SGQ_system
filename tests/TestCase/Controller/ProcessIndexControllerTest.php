<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ProcessIndexController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ProcessIndexController Test Case
 *
 * @link \App\Controller\ProcessIndexController
 */
class ProcessIndexControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProcessIndex',
        'app.ProductFamilies',
    ];

    /**
     * Test index method
     *
     * @return void
     * @link \App\Controller\ProcessIndexController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\ProcessIndexController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\ProcessIndexController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\ProcessIndexController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\ProcessIndexController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
