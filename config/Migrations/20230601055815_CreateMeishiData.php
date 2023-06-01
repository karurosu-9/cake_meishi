<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMeishiData extends AbstractMigration
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
        $table = $this->table('meishi_data');
        $table->addColumn('corp_id', 'integer', [
            'limit'=> 255,
            'null' => false,
        ])
        ->addColumn('division', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('title', 'string', [
            'limit' => 50,
            'null' => true,
        ])
        ->addColumn('employee_name', 'string', [
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('address', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('tel', 'string', [
            'limit' => 13,
            'null' => true,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->create();
    }
}
