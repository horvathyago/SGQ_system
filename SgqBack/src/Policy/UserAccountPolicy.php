<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\UserAccount;
use Authorization\IdentityInterface;

/**
 * UserAccount policy
 */
class UserAccountPolicy
{
    /**
     * Check if $user can add UserAccount
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\UserAccount $userAccount
     * @return bool
     */
    public function canAdd(IdentityInterface $user, UserAccount $userAccount)
    {
        return $user->getOriginalData()->role === 'admin';
    }

    /**
     * Check if $user can edit UserAccount
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\UserAccount $userAccount
     * @return bool
     */
    public function canEdit(IdentityInterface $user, UserAccount $userAccount)
    {
    }

    /**
     * Check if $user can delete UserAccount
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\UserAccount $userAccount
     * @return bool
     */
    public function canDelete(IdentityInterface $user, UserAccount $userAccount)
    {
    }

    /**
     * Check if $user can view UserAccount
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\UserAccount $userAccount
     * @return bool
     */
    public function canView(IdentityInterface $user, UserAccount $userAccount)
    {
    }
}
