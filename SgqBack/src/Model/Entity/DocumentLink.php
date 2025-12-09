<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DocumentLink Entity
 *
 * @property string $id
 * @property string $document_id
 * @property string $entity_type
 * @property string $entity_id
 * @property string|null $expected_type
 * @property bool|null $is_required
 * @property bool|null $is_validated
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\Document $document
 */
class DocumentLink extends Entity
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
        'document_id' => true,
        'entity_type' => true,
        'entity_id' => true,
        'expected_type' => true,
        'is_required' => true,
        'is_validated' => true,
        'created_at' => true,
        'document' => true,
    ];
}
