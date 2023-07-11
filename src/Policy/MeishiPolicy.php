<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Meishi;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Meishi policy
 */
class MeishiPolicy implements BeforePolicyInterface
{
    //管理者は全てのアクションにアクセスできる
    public function before($user, $resource, $action)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Check if $user can add Meishi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Meishi $meishi
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Meishi $meishi)
    {
        return true;
    }

    /**
     * Check if $user can edit Meishi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Meishi $meishi
     * @return bool
     */
    public function canEdit(IdentityInterface $user)
    {
        $user->authorized_user; 
    }

    /**
     * Check if $user can delete Meishi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Meishi $meishi
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Meishi $meishi)
    {
        $user->authorized_user;
    }

    /**
     * Check if $user can view Meishi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Meishi $meishi
     * @return bool
     */
    public function canView(IdentityInterface $user, Meishi $meishi)
    {
    }
}
