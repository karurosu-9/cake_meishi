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
                'created' => '2023-05-31 14:27:38',
                'modified' => '2023-05-31 14:27:38',
            ],
        ];
        parent::init();
    }
}
