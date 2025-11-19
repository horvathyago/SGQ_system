<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InspectionItemFixture
 */
class InspectionItemFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'inspection_item';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'c20e2843-cdaf-4e6d-82b4-c875555d10f7',
                'inspection_id' => '0937a62b-a4ca-4441-8e98-b0949d11d107',
                'item_master_id' => 'a8a9079d-31e0-4cb8-a487-38a683b32052',
                'item_master_version' => 1,
                'template_item_id' => '40550ce4-54e1-45e3-9625-8a7fddea715b',
                'ordem' => 1,
                'codigo_item_snapshot' => 'Lorem ipsum dolor sit amet',
                'titulo_snapshot' => 'Lorem ipsum dolor sit amet',
                'peso_snapshot' => 1.5,
                'is_fca_snapshot' => 1,
                'escopo_snapshot' => 'Lorem ipsum dolor sit amet',
                'nota_inspector' => 1,
                'is_nsa' => 1,
                'measured_value' => 'Lorem ipsum dolor sit amet',
                'comentario' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'wdl_calculado' => 1.5,
                'requires_evidence' => 1,
                'has_evidence' => 1,
                'calibration_record_id' => '22449d20-2e0f-4f1d-9778-3768fc693060',
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
