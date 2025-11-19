<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CalibrationRecord Entity
 *
 * @property string $id
 * @property string|null $gauge_id
 * @property \Cake\I18n\DateTime|null $data_calibracao
 * @property \Cake\I18n\DateTime|null $validade
 * @property string|null $laudo_document_id
 * @property int|null $versao
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\Gauge $gauge
 * @property \App\Model\Entity\Document $laudo_document
 * @property \App\Model\Entity\InspectionItem[] $inspection_item
 */
class CalibrationRecord extends Entity
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
        'gauge_id' => true,
        'data_calibracao' => true,
        'validade' => true,
        'laudo_document_id' => true,
        'versao' => true,
        'created_at' => true,
        'updated_at' => true,
        'gauge' => true,
        'laudo_document' => true,
        'inspection_item' => true,
    ];
}
