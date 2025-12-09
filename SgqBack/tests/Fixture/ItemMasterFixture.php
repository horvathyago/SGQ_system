<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemMasterFixture
 */
class ItemMasterFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'item_master';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '39d06274-7586-4dc1-b7db-4df459ce9650',
                'codigo_item' => 'Lorem ipsum dolor sit amet',
                'titulo' => 'Lorem ipsum dolor sit amet',
                'versao_mestra' => 1,
                'peso' => 1.5,
                'is_fca' => 1,
                'escopo' => 'Lorem ipsum dolor sit amet',
                'vigente_inicio' => '',
                'vigente_fim' => '',
                'is_ativo' => 1,
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
