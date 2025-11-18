<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TemplateItem Entity
 */
class TemplateItem extends Entity
{
    protected array $_accessible = [
        'checklist_template_version_id' => true,
        'item_master_id' => true,
        'item_master_version' => true,
        'ordem' => true,
        'metodologia' => true,
        'rigor_tecnico' => true,
        'acao_imediata' => true,
        'required' => true,
        'notes' => true,
        'created_at' => true,
        'checklist_template_version' => true,
        'item_master' => true,
        'inspection_item' => true,
    ];
}