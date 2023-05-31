<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'division' => 'Lorem ipsum dolor sit amet',
                'userName' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'admin' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-05-30 17:32:39',
                'modified' => '2023-05-30 17:32:39',
            ],
        ];
        parent::init();
    }
}
