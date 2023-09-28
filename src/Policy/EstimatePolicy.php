<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Estimate;
use Authorization\IdentityInterface;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Estimate policy
 */
class EstimatePolicy implements BeforePolicyInterface
{
    //管理者は全てのアクションにアクセスできる
    public function before($user, $resource, $action)
    {
        if ($user->is_admin) {
            return true;
        }
    }
    /**
     * Check if $user can add Estimate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estimate $estimate
     * @return bool
     */
    public function canAdd(IdentityInterface $user)
    {
        return $user->authorized_user || $user->admin === '経理';
    }

    public function canConfirmEstimate(IdentityInterface $user) {
        return $user->authorized_user || $user->admin === '経理';
    }

    /**
     * Check if $user can edit Estimate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estimate $estimate
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Estimate $estimate)
    {
        return $user->authorized_user || $user->admin === '経理';
    }

    /**
     * Check if $user can delete Estimate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estimate $estimate
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Estimate $estimate)
    {
        return $user->authorized_user || $user->admin === '経理';
    }

    /**
     * Check if $user can view Estimate
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Estimate $estimate
     * @return bool
     */
    public function canView(IdentityInterface $user, Estimate $estimate)
    {
    }
}
