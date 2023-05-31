<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DivisionsFixture
 */
class DivisionsFixture extends TestFixture
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
                'divisionName' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'created' => '2023-05-30 18:02:13',
                'modified' => '2023-05-30 18:02:13',
            ],
        ];
        parent::init();
    }
}
