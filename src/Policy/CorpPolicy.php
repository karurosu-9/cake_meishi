<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Corp;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Corp policy
 */
class CorpPolicy implements BeforePolicyInterface
{
    //管理者は全てのアクションにアクセスできる
    public function before($user, $resource, $action)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    /**
     * Check if $user can add Corp
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Corp $corp
     * @return bool
     */
    public function canAdd(IdentityInterface $user)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can edit Corp
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Corp $corp
     * @return bool
     */
    public function canEdit(IdentityInterface $user)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can delete Corp
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Corp $corp
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Corp $corp)
    {
        return $user->authorized_user;
    }

    /**
     * Check if $user can view Corp
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Corp $corp
     * @return bool
     */
    public function canView(IdentityInterface $user, Corp $corp)
    {
    }
}
