<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estimate Entity
 *
 * @property int $id
 * @property int $corp_id
 * @property string $tekiyo1
 * @property string $unit_price1
 * @property string $quantity1
 * @property string $amount1
 * @property string|null $note1
 * @property string|null $tekiyo2
 * @property string|null $unit_price2
 * @property string|null $quantity2
 * @property string|null $amount2
 * @property string|null $note2
 * @property string|null $tekiyo3
 * @property string|null $unit_price3
 * @property string|null $quantity3
 * @property string|null $amount3
 * @property string|null $note3
 * @property string|null $tekiyo4
 * @property string|null $unit_price4
 * @property string|null $quantity4
 * @property string|null $amount4
 * @property string|null $note4
 * @property string|null $tekiyo5
 * @property string|null $unit_price5
 * @property string|null $quantity5
 * @property string|null $amount5
 * @property string|null $note5
 * @property string|null $hosoku1
 * @property string|null $hosoku2
 * @property string|null $hosoku3
 * @property int $total_amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Corp $corp
 */
class Estimate extends Entity
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
        'tekiyo1' => true,
        'unit_price1' => true,
        'quantity1' => true,
        'amount1' => true,
        'note1' => true,
        'tekiyo2' => true,
        'unit_price2' => true,
        'quantity2' => true,
        'amount2' => true,
        'note2' => true,
        'tekiyo3' => true,
        'unit_price3' => true,
        'quantity3' => true,
        'amount3' => true,
        'note3' => true,
        'tekiyo4' => true,
        'unit_price4' => true,
        'quantity4' => true,
        'amount4' => true,
        'note4' => true,
        'tekiyo5' => true,
        'unit_price5' => true,
        'quantity5' => true,
        'amount5' => true,
        'note5' => true,
        'hosoku1' => true,
        'hosoku2' => true,
        'hosoku3' => true,
        'total_amount' => true,
        'created' => true,
        'modified' => true,
        'corp' => true,
    ];
}
