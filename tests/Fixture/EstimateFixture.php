<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EstimateFixture
 */
class EstimateFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'estimate';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'corp_id' => 1,
                'tekiyo1' => 'Lorem ipsum dolor sit amet',
                'unit_price1' => 'Lorem ipsum dolor sit amet',
                'quantity1' => 'Lorem ipsum dolor sit amet',
                'amount1' => 'Lorem ipsum dolor sit amet',
                'note1' => 'Lorem ipsum dolor sit amet',
                'tekiyo2' => 'Lorem ipsum dolor sit amet',
                'unit_price2' => 'Lorem ipsum dolor sit amet',
                'quantity2' => 'Lorem ipsum dolor sit amet',
                'amount2' => 'Lorem ipsum dolor sit amet',
                'note2' => 'Lorem ipsum dolor sit amet',
                'tekiyo3' => 'Lorem ipsum dolor sit amet',
                'unit_price3' => 'Lorem ipsum dolor sit amet',
                'quantity3' => 'Lorem ipsum dolor sit amet',
                'amount3' => 'Lorem ipsum dolor sit amet',
                'note3' => 'Lorem ipsum dolor sit amet',
                'tekiyo4' => 'Lorem ipsum dolor sit amet',
                'unit_price4' => 'Lorem ipsum dolor sit amet',
                'quantity4' => 'Lorem ipsum dolor sit amet',
                'amount4' => 'Lorem ipsum dolor sit amet',
                'note4' => 'Lorem ipsum dolor sit amet',
                'tekiyo5' => 'Lorem ipsum dolor sit amet',
                'unit_price5' => 'Lorem ipsum dolor sit amet',
                'quantity5' => 'Lorem ipsum dolor sit amet',
                'amount5' => 'Lorem ipsum dolor sit amet',
                'note5' => 'Lorem ipsum dolor sit amet',
                'hosoku1' => 'Lorem ipsum dolor sit amet',
                'hosoku2' => 'Lorem ipsum dolor sit amet',
                'hosoku3' => 'Lorem ipsum dolor sit amet',
                'total_amount' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-06-08 09:17:19',
                'modified' => '2023-06-08 09:17:19',
            ],
        ];
        parent::init();
    }
}
