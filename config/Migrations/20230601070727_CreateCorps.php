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
        $table->addColumn('corp_name', 'string', [
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->addIndex('corp_name', ['unique' => 'true']);
        $table->create();
    }
}
