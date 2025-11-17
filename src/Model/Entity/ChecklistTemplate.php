<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChecklistTemplate Entity
 *
 * @property string $id
 * @property string $name
 * @property string|null $tipo
 * @property string|null $descricao
 * @property bool|null $is_active
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\ChecklistTemplateVersion[] $checklist_template_version
 * @property \App\Model\Entity\Inspection[] $inspection
 * @property \App\Model\Entity\ProductFamilyChecklist[] $product_family_checklist
 */
class ChecklistTemplate extends Entity
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
        'name' => true,
        'tipo' => true,
        'descricao' => true,
        'is_active' => true,
        'created_at' => true,
        'updated_at' => true,
        'checklist_template_version' => true,
        'inspection' => true,
        'product_family_checklist' => true,
    ];
}
