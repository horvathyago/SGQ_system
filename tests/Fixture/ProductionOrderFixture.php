<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductionOrderFixture
 */
class ProductionOrderFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'production_order';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 'd9dc697c-4b37-4c43-8485-02cc75c6e5b5',
                'numero_op' => 'Lorem ipsum dolor sit amet',
                'produto_codigo' => 'Lorem ipsum dolor sit amet',
                'product_family_id' => 'eeb9ab69-b5de-447f-a71a-351e01234a18',
                'lot_code' => 'Lorem ipsum dolor sit amet',
                'quantidade_planejada' => 1,
                'data_inicio' => '',
                'data_fim' => '',
                'status' => 'Lorem ipsum dolor sit amet',
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
