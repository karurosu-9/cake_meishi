<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MeishiDataFixture
 */
class MeishiDataFixture extends TestFixture
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
                'corp_id' => 1,
                'division' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'employee_name' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'tel' => 'Lorem ipsum',
                'created' => '2023-06-01 16:50:05',
                'modified' => '2023-06-01 16:50:05',
            ],
        ];
        parent::init();
    }
}
