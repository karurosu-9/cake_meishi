<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMyCorps extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('my_corps');
        $table->addColumn('corp', 'string', [
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('post_code', 'string', [
            'limit' => 7,
            'null' => false,
        ])
        ->addColumn('address', 'string', [
            'limit' => 100,
            'null' => false,
        ])
        ->addColumn('tel', 'string', [
            'limit' => 13,
            'null' => false,
        ])
        ->addColumn('fax', 'string', [
            'limit' => 13,
            'null' => false,
        ])
        ->addColumn('place', 'string', [
            'limit' => 10,
            'null' => false,
        ])
        ->addColumn('conditions', 'string', [
            'limit' => 10,
            'null' => false,
        ])
        ->addColumn('deadline', 'string', [
            'limit' => 10,
            'null' => false,
        ]);
        $table->create();
    }
}
