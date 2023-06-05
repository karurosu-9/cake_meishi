<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meishi Entity
 *
 * @property int $id
 * @property int $corp_id
 * @property string $division
 * @property string|null $title
 * @property string $employee_name
 * @property string|null $tel
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Corp $corp
 */
class Meishi extends Entity
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
        'corp_id' => true,
        'division' => true,
        'title' => true,
        'employee_name' => true,
        'tel' => true,
        'created' => true,
        'modified' => true,
        'corp' => true,
    ];
}
