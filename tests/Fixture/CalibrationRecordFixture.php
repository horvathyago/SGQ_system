<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CalibrationRecordFixture
 */
class CalibrationRecordFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'calibration_record';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'd1171cc4-1d6d-4e87-85b5-e5a74ad07372',
                'gauge_id' => '3b3eadab-e535-4b74-91c8-89e47f2fcfa0',
                'data_calibracao' => '',
                'validade' => '',
                'laudo_document_id' => 'cbe10ad5-2893-4794-aa57-25ff686a6121',
                'versao' => 1,
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
