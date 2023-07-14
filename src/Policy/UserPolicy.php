<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * User policy
 */
class UserPolicy implements BeforePolicyInterface
{
    //管理者は全てのアクションにアクセスできる
    public function before($user, $resource, $action)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Check if $user can add User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canAdd(IdentityInterface $user): bool
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can edit User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canEdit(IdentityInterface $user, User $modelUser)
    {
        return ($user->authorized_user || $user->id === $modelUser->id);
    }

    /**
     * Check if $user can delete User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canDelete(IdentityInterface $user, User $resource)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can view User
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\User $resource
     * @return bool
     */
    public function canView(IdentityInterface $user, User $resource)
    {
        return true;
    }

    public function canChangePassword(IdentityInterface $user, User $modelUser)
    {
        return $user->authorized_user || $user->id === $modelUser->id;
    }
}
