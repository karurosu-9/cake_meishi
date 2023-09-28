<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyCorp Entity
 *
 * @property int $id
 * @property string $corp
 * @property string $post_code
 * @property string $address
 * @property string $tel
 * @property string $fax
 * @property string $place
 * @property string $conditions
 * @property string $deadline
 */
class MyCorp extends Entity
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
        'corp' => true,
        'post_code' => true,
        'address' => true,
        'tel' => true,
        'fax' => true,
        'place' => true,
        'conditions' => true,
        'deadline' => true,
    ];
}
