<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MrbActionFixture
 */
class MrbActionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'mrb_action';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'c7668a73-d2de-4d69-bf38-1c787d779a70',
                'non_conformity_id' => 'd0a8fb84-9fd1-4177-96d7-739e92b4de95',
                'decisao' => 'Lorem ipsum dolor sit amet',
                'responsavel_id' => 'fe07bcda-da86-4bea-b87f-8ea51490fd5c',
                'observacoes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
