<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ItemMaster;
use Authorization\IdentityInterface;

/**
 * ItemMaster policy
 */
class ItemMasterPolicy
{
    /**
     * Check if $user can add ItemMaster
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemMaster $itemMaster
     * @return bool
     */
    public function canAdd(IdentityInterface $user, ItemMaster $itemMaster)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can edit ItemMaster
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemMaster $itemMaster
     * @return bool
     */
    public function canEdit(IdentityInterface $user, ItemMaster $itemMaster)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can delete ItemMaster
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemMaster $itemMaster
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ItemMaster $itemMaster)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can view ItemMaster
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ItemMaster $itemMaster
     * @return bool
     */
    public function canView(IdentityInterface $user, ItemMaster $itemMaster)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor' || 'operador' || 'viwer';
    }
}
