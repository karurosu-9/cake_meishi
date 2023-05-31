<?php
declare(strict_types=1);

use Cake\I18n\FrozenTime;
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'division' => '経理部',
                'userName' => '太郎',
                'admin' => '一般',
                'password' => 'abc',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
