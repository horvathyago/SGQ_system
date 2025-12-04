<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Inspection;
use App\Model\Entity\UserAccount;
use Authorization\IdentityInterface;

/**
 * Inspection policy
 */
class InspectionPolicy
{
    /**
     * Check if $user can add Inspection
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Inspection $inspection
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Inspection $inspection)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor' || 'operador';
    }

    /**
     * Check if $user can edit Inspection
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Inspection $inspection
     * @return bool
     * @param \App\Model\Entity\UserAccount $usuario
     */
    public function canEdit(IdentityInterface $user, Inspection $inspection): bool
    {
        $userData = $user->getOriginalData();
        $role = $userData->role;
        $userId = $userData->id;

        // Admin e Supervisor podem editar qualquer inspeção
        if (in_array($role, ['admin', 'supervisor'], true)) {
            return true;
        }

        // Operador só pode editar inspeções criadas por ele
        if ($role === 'operador') {
            return $inspection->inspector_id === $userId;
        }

        // Todos os outros usuários são bloqueados
        return false;
    }


    /**
     * Check if $user can delete Inspection
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Inspection $inspection
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Inspection $inspection)
    {
        return $user->getOriginalData()->role === 'admin' || 'supervisor';
    }

    /**
     * Check if $user can view Inspection
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Inspection $inspection
     * @return bool
     */
    public function canView(IdentityInterface $user, Inspection $inspection) {}
}
