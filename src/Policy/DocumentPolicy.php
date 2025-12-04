<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Document;
use Authorization\IdentityInterface;

/**
 * Document policy
 */
class DocumentPolicy
{
    /**
     * Check if $user can add Document
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Document $document
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Document $document)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can edit Document
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Document $document
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Document $document)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can delete Document
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Document $document
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Document $document)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can view Document
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Document $document
     * @return bool
     */
    public function canView(IdentityInterface $user, Document $document)
    {
        return true;
    }
}
