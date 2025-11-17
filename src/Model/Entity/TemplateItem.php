<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TemplateItem Entity
 *
 * @property string $id
 * @property string $checklist_template_version_id
 * @property string $item_master_id
 * @property int|null $item_master_version
 * @property int $ordem
 * @property bool|null $required
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\ChecklistTemplateVersion $checklist_template_version
 * @property \App\Model\Entity\ItemMaster $item_master
 * @property \App\Model\Entity\InspectionItem[] $inspection_item
 */
class TemplateItem extends Entity
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
        'checklist_template_version_id' => true,
        'item_master_id' => true,
        'item_master_version' => true,
        'ordem' => true,
        'required' => true,
        'notes' => true,
        'created_at' => true,
        'checklist_template_version' => true,
        'item_master' => true,
        'inspection_item' => true,
    ];
}
