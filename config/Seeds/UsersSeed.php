<?php

declare(strict_types=1);

use Cake\I18n\FrozenTime;
use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

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
                'user_name' => 'testuser1',
                'password' => $this->hashPassword('test1'),
                'division_id' => 1,
                'admin' => '管理者',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'user_name' => 'testuser2',
                'password' => $this->hashPassword('test2'),
                'division_id' => 2,
                'admin' => '経理',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }

    private function hashPassword(string $password): string
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }
}
