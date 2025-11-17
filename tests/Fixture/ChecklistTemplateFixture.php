<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChecklistTemplateFixture
 */
class ChecklistTemplateFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'checklist_template';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '753b305f-c139-4bd8-9d88-581c88b413e1',
                'name' => 'Lorem ipsum dolor sit amet',
                'tipo' => 'Lorem ipsum dolor sit amet',
                'descricao' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_active' => 1,
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
