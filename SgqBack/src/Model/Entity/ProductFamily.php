<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductFamily Entity
 *
 * @property string $id
 * @property string $codigo
 * @property string $nome
 * @property string|null $descricao
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Lot[] $lot
 * @property \App\Model\Entity\ProcessIndex[] $process_index
 * @property \App\Model\Entity\ProductFamilyChecklist[] $product_family_checklist
 * @property \App\Model\Entity\ProductionOrder[] $production_order
 */
class ProductFamily extends Entity
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
        'codigo' => true,
        'nome' => true,
        'descricao' => true,
        'created_at' => true,
        'updated_at' => true,
        'lot' => true,
        'process_index' => true,
        'product_family_checklist' => true,
        'production_order' => true,
    ];
}
