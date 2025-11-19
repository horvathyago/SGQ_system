<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductFamilyChecklistFixture
 */
class ProductFamilyChecklistFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'product_family_checklist';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'e63d3cad-4345-4375-8b1c-8196743d3cc8',
                'product_family_id' => 'a97e19a5-99ca-4c32-8e5b-15ce42b0f99a',
                'checklist_template_id' => 'd367cccb-e410-4bcb-977a-67908df535ca',
                'tipo' => 'Lorem ipsum dolor sit amet',
                'created_at' => '',
            ],
        ];
        parent::init();
    }
}
