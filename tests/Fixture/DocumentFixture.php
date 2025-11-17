<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentFixture
 */
class DocumentFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'document';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '0975d098-7489-433d-88dc-ab701e2b2de5',
                'filename' => 'Lorem ipsum dolor sit amet',
                'mime_type' => 'Lorem ipsum dolor sit amet',
                'storage_path' => 'Lorem ipsum dolor sit amet',
                'uploader_id' => '702ae79a-67ae-47d1-b85e-525dd7f0058e',
                'tamanho_bytes' => 1,
                'doc_hash' => 'Lorem ipsum dolor sit amet',
                'tipo' => 'Lorem ipsum dolor sit amet',
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_validated' => 1,
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
