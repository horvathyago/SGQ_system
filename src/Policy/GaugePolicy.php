<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Gauge;
use Authorization\IdentityInterface;

/**
 * Gauge policy
 */
class GaugePolicy
{
    /**
     * Check if $user can add Gauge
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Gauge $gauge
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Gauge $gauge)
    {
         return $user->getOriginalData()->role === 'admin' || $user->getOriginalData()->role === 'supervisor';
        

    }

    /**
     * Check if $user can edit Gauge
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Gauge $gauge
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Gauge $gauge)
    {
    }

    /**
     * Check if $user can delete Gauge
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Gauge $gauge
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Gauge $gauge)
    {
    }

    /**
     * Check if $user can view Gauge
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Gauge $gauge
     * @return bool
     */
    public function canView(IdentityInterface $user, Gauge $gauge)
    {
    }
}
