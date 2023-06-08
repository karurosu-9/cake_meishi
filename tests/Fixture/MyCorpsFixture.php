<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MyCorpsFixture
 */
class MyCorpsFixture extends TestFixture
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
                'corp' => 'Lorem ipsum dolor sit amet',
                'post_code' => 'Lorem',
                'address' => 'Lorem ipsum dolor sit amet',
                'tel' => 'Lorem ipsum',
                'fax' => 'Lorem ipsum',
                'place' => 'Lorem ip',
                'conditions' => 'Lorem ip',
                'deadline' => 'Lorem ip',
            ],
        ];
        parent::init();
    }
}
