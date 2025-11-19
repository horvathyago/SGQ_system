<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProcessIndexFixture
 */
class ProcessIndexFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'process_index';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '8a145fde-0e56-415a-a9dd-4b75b5322412',
                'periodo' => '2025-11-19',
                'indicador' => 'Lorem ipsum dolor sit amet',
                'product_family_id' => '26dabfc4-f9d8-4de2-82cb-c605d5515d65',
                'valor' => 1.5,
                'unidade' => 'Lorem ipsum dolor sit amet',
                'detalhes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
