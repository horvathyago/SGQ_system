<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemMaster Entity
 *
 * @property string $id
 * @property string $codigo_item
 * @property string|null $titulo
 * @property int|null $versao_mestra
 * @property string|null $peso
 * @property bool|null $is_fca
 * @property string|null $escopo
 * @property \Cake\I18n\DateTime|null $vigente_inicio
 * @property \Cake\I18n\DateTime|null $vigente_fim
 * @property bool|null $is_ativo
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\InspectionItem[] $inspection_item
 * @property \App\Model\Entity\ItemMasterVersion[] $item_master_version
 * @property \App\Model\Entity\TemplateItem[] $template_item
 */
class ItemMaster extends Entity
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
        'codigo_item' => true,
        'titulo' => true,
        'versao_mestra' => true,
        'peso' => true,
        'is_fca' => true,
        'escopo' => true,
        'vigente_inicio' => true,
        'vigente_fim' => true,
        'is_ativo' => true,
        'created_at' => true,
        'updated_at' => true,
        'inspection_item' => true,
        'item_master_version' => true,
        'template_item' => true,
    ];
}
