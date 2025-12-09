<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChecklistTemplateVersion Entity
 *
 * @property string $id
 * @property string $checklist_template_id
 * @property int $versao
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\ChecklistTemplate $checklist_template
 * @property \App\Model\Entity\Inspection[] $inspection
 * @property \App\Model\Entity\TemplateItem[] $template_item
 */
class ChecklistTemplateVersion extends Entity
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
        'checklist_template_id' => true,
        'versao' => true,
        'notes' => true,
        'created_at' => true,
        'checklist_template' => true,
        'inspection' => true,
        'template_item' => true,
    ];
}
