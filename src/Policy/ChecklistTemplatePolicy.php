<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ChecklistTemplate;
use Authorization\IdentityInterface;

/**
 * ChecklistTemplate policy
 */
class ChecklistTemplatePolicy
{
    /**
     * Check if $user can add ChecklistTemplate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ChecklistTemplate $checklistTemplate
     * @return bool
     */
    public function canAdd(IdentityInterface $user, ChecklistTemplate $checklistTemplate)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }
    

    /**
     * Check if $user can edit ChecklistTemplate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ChecklistTemplate $checklistTemplate
     * @return bool
     */
    public function canEdit(IdentityInterface $user, ChecklistTemplate $checklistTemplate)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can delete ChecklistTemplate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ChecklistTemplate $checklistTemplate
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ChecklistTemplate $checklistTemplate)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can view ChecklistTemplate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\ChecklistTemplate $checklistTemplate
     * @return bool
     */
    public function canView(IdentityInterface $user, ChecklistTemplate $checklistTemplate)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }
}
