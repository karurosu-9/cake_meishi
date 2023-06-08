<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * MyCorp seed.
 */
class MyCorpSeed extends AbstractSeed
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
                'corp' => '株式会社アスカプランニング',
                'post_code' => '1234567',
                'address' => '東京都新宿区',
                'tel' => '1234567890',
                'fax' => '1234567890',
                'place' => '貴社',
                'conditions' => '従来通り',
                'deadline' => '一ヶ月',
            ],
        ];

        $table = $this->table('my_corps');
        $table->insert($data)->save();
    }
}
