<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Division;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Division policy
 */
class DivisionPolicy implements BeforePolicyInterface
{
    //管理者は全てのアクションにアクセスできる
    public function before($user, $resource, $action)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    /**
     * Check if $user can add Division
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Division $division
     * @return bool
     */
    public function canAdd(IdentityInterface $user)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can edit Division
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Division $division
     * @return bool
     */
    public function canEdit(IdentityInterface $user)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can delete Division
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Division $division
     * @return bool
     */
    public function canDelete(IdentityInterface $user)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can view Division
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Division $division
     * @return bool
     */
    public function canView(IdentityInterface $user, Division $division)
    {
    }
}
