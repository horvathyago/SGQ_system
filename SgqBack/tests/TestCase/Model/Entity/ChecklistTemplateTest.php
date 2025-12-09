<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\ChecklistTemplate;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\ChecklistTemplate Test Case
 */
class ChecklistTemplateTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\ChecklistTemplate
     */
    protected $ChecklistTemplate;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->ChecklistTemplate = new ChecklistTemplate();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ChecklistTemplate);

        parent::tearDown();
    }
}
