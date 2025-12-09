<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductionOrder Entity
 *
 * @property string $id
 * @property string $numero_op
 * @property string|null $produto_codigo
 * @property string|null $product_family_id
 * @property string|null $lot_code
 * @property int|null $quantidade_planejada
 * @property \Cake\I18n\DateTime|null $data_inicio
 * @property \Cake\I18n\DateTime|null $data_fim
 * @property string|null $status
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\ProductFamily $product_family
 * @property \App\Model\Entity\Inspection[] $inspection
 * @property \App\Model\Entity\Lot[] $lot
 */
class ProductionOrder extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'numero_op' => true,
        'produto_codigo' => true,
        'product_family_id' => true,
        'lot_code' => true,
        'quantidade_planejada' => true,
        'data_inicio' => true,
        'data_fim' => true,
        'status' => true,
        'created_at' => true,
        'updated_at' => true,
        'product_family' => true,
        'inspection' => true,
        'lot' => true,
    ];
}
