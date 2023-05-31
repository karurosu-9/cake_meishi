<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('division', 'string', [
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('userName', 'string', [
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('password', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('admin', 'string', [
            'default' => '一般',
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->create();
    }
}
