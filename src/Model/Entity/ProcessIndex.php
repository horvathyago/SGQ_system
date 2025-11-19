<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProcessIndex Entity
 *
 * @property string $id
 * @property \Cake\I18n\Date|null $periodo
 * @property string|null $indicador
 * @property string|null $product_family_id
 * @property string|null $valor
 * @property string|null $unidade
 * @property string|null $detalhes
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\ProductFamily $product_family
 */
class ProcessIndex extends Entity
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
        'periodo' => true,
        'indicador' => true,
        'product_family_id' => true,
        'valor' => true,
        'unidade' => true,
        'detalhes' => true,
        'created_at' => true,
        'updated_at' => true,
        'product_family' => true,
    ];
}
