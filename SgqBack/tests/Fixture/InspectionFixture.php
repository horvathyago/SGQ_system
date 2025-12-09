<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InspectionFixture
 */
class InspectionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'inspection';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '6e91af7c-ae69-45da-b830-08e5221adc73',
                'production_order_id' => 'd4bfa156-d59e-45c3-b49c-a2875339f848',
                'checklist_template_id' => '41bc60bd-2518-4d2a-bdcb-264fe7be7fca',
                'checklist_template_version_id' => 'f48a767c-52ea-4624-bd36-fe280610d57a',
                'inspector_id' => 'e46282a1-5459-4466-8ee4-92e06e57711c',
                'lot_code' => 'Lorem ipsum dolor sit amet',
                'origem' => 'Lorem ipsum dolor sit amet',
                'wdl_calculado' => 1.5,
                'wdl_max_utilizado' => 1.5,
                'nota_final' => 1.5,
                'status_final' => 'Lorem ipsum dolor sit amet',
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
