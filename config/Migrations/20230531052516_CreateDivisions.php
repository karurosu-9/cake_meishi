<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateDivisions extends AbstractMigration
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
        $table = $this->table('divisions');
        $table->addColumn('division_name', 'string', [
            'limit' => 100,
            'null' => false,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->addIndex('divisionName', ['unique' => 'true']);
        $table->create();
    }
}
