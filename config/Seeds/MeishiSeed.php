<?php
declare(strict_types=1);

use Cake\I18n\FrozenTime;
use Migrations\AbstractSeed;

/**
 * MeishiData seed.
 */
class MeishiSeed extends AbstractSeed
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
                'corp_id' => 1,
                'division' => '営業部',
                'title' => '課長',
                'employee_name' => 'アスカ太郎',
                'tel' => '0120117117',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'corp_id' => 2,
                'division' => '経理部',
                'title' => '部長',
                'employee_name' => 'アスカ花子',
                'tel' => '0120117117',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'corp_id' => 3,
                'division' => 'システム部',
                'title' => '',
                'employee_name' => 'アスカさち子',
                'tel' => '0120117117',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
        ];

        $table = $this->table('meishi');
        $table->insert($data)->save();
    }
}
