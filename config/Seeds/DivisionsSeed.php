<?php
declare(strict_types=1);

use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Migrations\AbstractSeed;

/**
 * Divisions seed.
 */
class DivisionsSeed extends AbstractSeed
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
                'divisionName' => '経理部',
                'user_id' => 1,
                'created' => FrozenTime::now(),
                'modified' => FrozenTime::now(),
            ],
        ];

        $table = $this->table('divisions');
        $table->insert($data)->save();
    }
}
