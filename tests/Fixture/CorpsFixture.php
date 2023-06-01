<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CorpsFixture
 */
class CorpsFixture extends TestFixture
{
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
                'corp_name' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-06-01 16:49:32',
                'modified' => '2023-06-01 16:49:32',
            ],
        ];
        parent::init();
    }
}
