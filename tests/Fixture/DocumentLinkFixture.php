<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentLinkFixture
 */
class DocumentLinkFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'document_link';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '77f4df5a-33c7-4326-bf5e-53561bcf18ba',
                'document_id' => 'ebb5ea0a-935d-45d5-94e6-cc5703b032db',
                'entity_type' => 'Lorem ipsum dolor sit amet',
                'entity_id' => '021ff965-816c-4262-881d-c915ebf68249',
                'expected_type' => 'Lorem ipsum dolor sit amet',
                'is_required' => 1,
                'is_validated' => 1,
                'created_at' => '',
            ],
        ];
        parent::init();
    }
}
