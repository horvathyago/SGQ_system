<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Inspection Entity
 *
 * @property string $id
 * @property string|null $production_order_id
 * @property string|null $checklist_template_id
 * @property string|null $checklist_template_version_id
 * @property string|null $inspector_id
 * @property string|null $lot_code
 * @property string|null $origem
 * @property string|null $wdl_calculado
 * @property string|null $wdl_max_utilizado
 * @property string|null $nota_final
 * @property string|null $status_final
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\ProductionOrder $production_order
 * @property \App\Model\Entity\ChecklistTemplate $checklist_template
 * @property \App\Model\Entity\ChecklistTemplateVersion $checklist_template_version
 * @property \App\Model\Entity\UserAccount $inspector
 * @property \App\Model\Entity\InspectionItem[] $inspection_item
 */
class Inspection extends Entity
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
        'production_order_id' => true,
        'checklist_template_id' => true,
        'checklist_template_version_id' => true,
        'inspector_id' => true,
        'lot_code' => true,
        'origem' => true,
        'wdl_calculado' => true,
        'wdl_max_utilizado' => true,
        'nota_final' => true,
        'status_final' => true,
        'created_at' => true,
        'updated_at' => true,
        'production_order' => true,
        'checklist_template' => true,
        'checklist_template_version' => true,
        'inspector' => true,
        'inspection_item' => true,
    ];
}
