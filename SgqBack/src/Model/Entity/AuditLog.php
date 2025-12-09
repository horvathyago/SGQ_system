<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditLog Entity
 *
 * @property string $id
 * @property string|null $entity_type
 * @property string|null $entity_id
 * @property string|null $user_id
 * @property string|null $action
 * @property string|null $delta
 * @property \Cake\I18n\DateTime $created_at
 *
 * @property \App\Model\Entity\UserAccount $user
 */
class AuditLog extends Entity
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
        'entity_type' => true,
        'entity_id' => true,
        'user_id' => true,
        'action' => true,
        'delta' => true,
        'created_at' => true,
        'user' => true,
    ];
}
