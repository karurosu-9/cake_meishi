<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

use PHPUnit\Framework\stringContains;

/**
 * User Entity
 *
 * @property int $id
 * @property string $userName
 * @property string $password
 * @property string $admin
 * @property int $division_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Division $division
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_name' => true,
        'password' => true,
        'admin' => true,
        'division_id' => true,
        'created' => true,
        'modified' => true,
        'division' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    //UserPolicy用のアクセス許可するユーザー
    protected function _getAuthorizedUser()
    {
        return $this->admin === 'システム';
    }

    //UserPolicy用のアクセス許可するユーザー
    protected function _getIsAdmin()
    {
        return $this->admin === '管理者';
    }

    //パスワードのハッシュ化
    protected function _setPassword(string $password) : ?string
    {
        if(strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
