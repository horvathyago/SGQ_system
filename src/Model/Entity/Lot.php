<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lot Entity
 *
 * @property string $id
 * @property string $lot_code
 * @property string|null $product_family_id
 * @property string|null $production_order_id
 * @property int|null $quantidade
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\ProductFamily $product_family
 * @property \App\Model\Entity\ProductionOrder $production_order
 */
class Lot extends Entity
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
        'lot_code' => true,
        'product_family_id' => true,
        'production_order_id' => true,
        'quantidade' => true,
        'created_at' => true,
        'updated_at' => true,
        'product_family' => true,
        'production_order' => true,
    ];
}
