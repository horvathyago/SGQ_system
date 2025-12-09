<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ChecklistTemplateVersionFixture
 */
class ChecklistTemplateVersionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'checklist_template_version';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '75de6326-5439-4a53-8ec1-7ae44c377342',
                'checklist_template_id' => '9d368bed-7d7c-4ce4-9a48-66ca06ea1b87',
                'versao' => 1,
                'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created_at' => '',
            ],
        ];
        parent::init();
    }
}
