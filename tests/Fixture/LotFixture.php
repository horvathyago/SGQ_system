<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LotFixture
 */
class LotFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'lot';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '3a1c1dc1-1498-4db8-8016-a9f9cb55dcea',
                'lot_code' => 'Lorem ipsum dolor sit amet',
                'product_family_id' => '8b671dbf-1d79-42d7-acff-9325e8b383d4',
                'production_order_id' => '83d728bd-e4be-4f84-b277-b50421fb64ee',
                'quantidade' => 1,
                'created_at' => '',
                'updated_at' => '',
            ],
        ];
        parent::init();
    }
}
