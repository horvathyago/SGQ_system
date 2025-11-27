<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\entity;
use Authorization\IdentityInterface;

/**
 * entity policy
 */
class entityPolicy
{
    /**
     * Check if $user can add entity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\entity $entity
     * @return bool
     */
    public function canAdd(IdentityInterface $user, entity $entity)
    {
    }

    /**
     * Check if $user can edit entity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\entity $entity
     * @return bool
     */
    public function canEdit(IdentityInterface $user, entity $entity)
    {
    }

    /**
     * Check if $user can delete entity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\entity $entity
     * @return bool
     */
    public function canDelete(IdentityInterface $user, entity $entity)
    {
    }

    /**
     * Check if $user can view entity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\entity $entity
     * @return bool
     */
    public function canView(IdentityInterface $user, entity $entity)
    {
    }
}
