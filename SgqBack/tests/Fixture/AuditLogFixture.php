<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuditLogFixture
 */
class AuditLogFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'audit_log';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '9b9e0b58-21f1-4e55-8424-4faa7109026a',
                'entity_type' => 'Lorem ipsum dolor sit amet',
                'entity_id' => 'ce4c5555-3e91-4db0-84e3-e2639870ee0d',
                'user_id' => '3e5c42b6-0709-49ce-85d6-8d20b9c02da3',
                'action' => 'Lorem ipsum dolor sit amet',
                'delta' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created_at' => '',
            ],
        ];
        parent::init();
    }
}
