<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\NonConformity;
use Authorization\IdentityInterface;

/**
 * NonConformity policy
 */
class NonConformityPolicy
{
    /**
     * Check if $user can add NonConformity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\NonConformity $nonConformity
     * @return bool
     */
    public function canAdd(IdentityInterface $user, NonConformity $nonConformity)
    {
    }

    /**
     * Check if $user can edit NonConformity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\NonConformity $nonConformity
     * @return bool
     */
    public function canEdit(IdentityInterface $user, NonConformity $nonConformity)
    {
    }

    /**
     * Check if $user can delete NonConformity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\NonConformity $nonConformity
     * @return bool
     */
    public function canDelete(IdentityInterface $user, NonConformity $nonConformity)
    {
    }

    /**
     * Check if $user can view NonConformity
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\NonConformity $nonConformity
     * @return bool
     */
    public function canView(IdentityInterface $user, NonConformity $nonConformity)
    {
    }
}
