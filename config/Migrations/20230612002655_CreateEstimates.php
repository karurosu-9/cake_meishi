<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use App\Consts\EstimateConst;

class CreateEstimates extends AbstractMigration
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
        $table = $this->table('estimates');
        $table->addColumn('corp_id', 'integer', [
            'null' => false,
        ]);

        $table->addColumn('tekiyo1', 'string', [
            'limit' => 255,
            'default' => null,
            'null' => false,
        ])
        ->addColumn('unit_price1', 'string', [
            'limit' => 50,
            'default' => null,
            'null' => false,
        ])
        ->addColumn('quantity1', 'string', [
            'limit' => 50,
            'default' => null,
            'null' => false,
        ])
        ->addColumn('amount1', 'string', [
            'limit' => 50,
            'default' => null,
            'null' => false,
        ])
        ->addColumn('note1', 'string', [
            'limit' => 255,
            'default' => null,
            'null' => true,
        ]);

        for ($i = 2; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
            $table->addColumn('tekiyo' . $i, 'string', [
                'limit' => 255,
                'default' => null,
                'null' => true,
            ])
            ->addColumn('unit_price' . $i, 'string', [
                'limit' => 50,
                'default' => null,
                'null' => true,
            ])
            ->addColumn('quantity' . $i, 'string', [
                'limit' => 50,
                'default' => null,
                'null' => true,
            ])
            ->addColumn('amount' . $i, 'string', [
                'limit' => 50,
                'default' => null,
                'null' => true,
            ])
            ->addColumn('note' . $i, 'string', [
                'limit' => 255,
                'default' => null,
                'null' => true,
            ]);
        }

        for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
            $table->addColumn('hosoku' . $i, 'string', [
                'limit' => 255,
                'default' => null,
                'null' => true,
            ]);
        }

        $table->addColumn('total_amount', 'integer', [
            'limit' => 100,
            'null' => false,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->create();
    }
}
