<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TemplateItemFixture
 */
class TemplateItemFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'template_item';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '120fb57a-4b7a-43a8-9154-39d9745585af',
                'checklist_template_version_id' => 'f1e71d4e-baa5-491e-98a6-0ef0fcb3989e',
                'item_master_id' => 'f482682e-9f3f-479e-8b01-1cb2a56b8449',
                'item_master_version' => 1,
                'ordem' => 1,
                'required' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created_at' => '',
            ],
        ];
        parent::init();
    }
}
