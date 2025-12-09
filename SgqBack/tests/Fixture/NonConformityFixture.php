<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NonConformityFixture
 */
class NonConformityFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'non_conformity';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '0e06d07a-0fbe-41b7-909c-a6fa582e2d7e',
                'inspection_item_id' => 'f800a3c4-4135-47fe-a2e9-6fd184df780c',
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'severity' => 'Lorem ipsum dolor sit amet',
                'is_fca_trigger' => 1,
                'disposition' => 'Lorem ipsum dolor sit amet',
                'responsavel_id' => 'fc36a45b-2b34-49d8-ad62-4d3a8fb677ae',
                'status' => 'Lorem ipsum dolor sit amet',
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
