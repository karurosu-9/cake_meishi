<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Meishi;
use Authorization\IdentityInterface;

/**
 * Meishi policy
 */
class MeishiPolicy
{
    /**
     * Check if $user can add Meishi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Meishi $meishi
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Meishi $meishi)
    {
    }

    /**
     * Check if $user can edit Meishi
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Meishi $meishi
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Meishi $meishi)
    {
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
