<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InspectionItem Entity
 *
 * @property string $id
 * @property string $inspection_id
 * @property string|null $item_master_id
 * @property int|null $item_master_version
 * @property string|null $template_item_id
 * @property int|null $ordem
 * @property string $codigo_item_snapshot
 * @property string|null $titulo_snapshot
 * @property string|null $peso_snapshot
 * @property bool|null $is_fca_snapshot
 * @property string|null $escopo_snapshot
 * @property int|null $nota_inspector
 * @property bool|null $is_nsa
 * @property string|null $measured_value
 * @property string|null $comentario
 * @property string|null $wdl_calculado
 * @property bool|null $requires_evidence
 * @property bool|null $has_evidence
 * @property string|null $calibration_record_id
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Inspection $inspection
 * @property \App\Model\Entity\ItemMaster $item_master
 * @property \App\Model\Entity\TemplateItem $template_item
 * @property \App\Model\Entity\CalibrationRecord $calibration_record
 * @property \App\Model\Entity\NonConformity[] $non_conformity
 */
class InspectionItem extends Entity
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
        'inspection_id' => true,
        'item_master_id' => true,
        'item_master_version' => true,
        'template_item_id' => true,
        'ordem' => true,
        'codigo_item_snapshot' => true,
        'titulo_snapshot' => true,
        'peso_snapshot' => true,
        'is_fca_snapshot' => true,
        'escopo_snapshot' => true,
        'nota_inspector' => true,
        'is_nsa' => true,
        'measured_value' => true,
        'comentario' => true,
        'wdl_calculado' => true,
        'requires_evidence' => true,
        'has_evidence' => true,
        'calibration_record_id' => true,
        'created_at' => true,
        'updated_at' => true,
        'inspection' => true,
        'item_master' => true,
        'template_item' => true,
        'calibration_record' => true,
        'non_conformity' => true,
    ];
}
