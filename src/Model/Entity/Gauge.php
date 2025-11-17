<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Gauge Entity
 *
 * @property string $id
 * @property string|null $serial
 * @property string|null $tipo
 * @property string|null $localizacao
 * @property string|null $status
 * @property string|null $descricao
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\CalibrationRecord[] $calibration_record
 */
class Gauge extends Entity
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
        'serial' => true,
        'tipo' => true,
        'localizacao' => true,
        'status' => true,
        'descricao' => true,
        'created_at' => true,
        'updated_at' => true,
        'calibration_record' => true,
    ];
}
