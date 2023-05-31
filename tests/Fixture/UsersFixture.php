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
                'userName' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'admin' => 'Lorem ipsum dolor sit amet',
                'division_id' => 1,
                'created' => '2023-05-31 14:27:19',
                'modified' => '2023-05-31 14:27:19',
            ],
        ];
        parent::init();
    }
}
