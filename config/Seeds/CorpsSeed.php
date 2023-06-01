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
                'corp_name' => '宇式通信株式会社',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'corp_name' => '大日本印刷株式会社',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'corp_name' => 'アスカ株式会社',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'corp_name' => 'ＡＢＣ株式会社',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
            [
                'corp_name' => '株式会社ＥＦＧ',
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
        ];

        $table = $this->table('corps');
        $table->insert($data)->save();
    }
}
