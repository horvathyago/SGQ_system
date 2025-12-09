<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductFamilyChecklist Entity
 *
 * @property string $id
 * @property string $product_family_id
 * @property string $checklist_template_id
 * @property string|null $tipo
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\ProductFamily $product_family
 * @property \App\Model\Entity\ChecklistTemplate $checklist_template
 */
class ProductFamilyChecklist extends Entity
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
        'product_family_id' => true,
        'checklist_template_id' => true,
        'tipo' => true,
        'created_at' => true,
        'product_family' => true,
        'checklist_template' => true,
    ];
}
