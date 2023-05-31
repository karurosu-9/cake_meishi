<?php
declare(strict_types=1);

use Cake\I18n\FrozenTime;
use Migrations\AbstractSeed;

/**
 * Corps seed.
 */
class CorpsSeed extends AbstractSeed
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
                'corpName' => '株式会社宇式通信',
                'personName' => '宇式　太郎',
                'address' => '東京都新宿区',
                'tel' => '0120117117',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
        ];

        $table = $this->table('corps');
        $table->insert($data)->save();
    }
}
