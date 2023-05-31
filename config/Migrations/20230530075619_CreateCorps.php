<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateCorps extends AbstractMigration
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
        $table = $this->table('corps');
        $table->addColumn('corpName', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('personName', 'string', [
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('address', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('tel', 'string', [
            'limit' => 13,
            'null' => false,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->create();
    }
}
