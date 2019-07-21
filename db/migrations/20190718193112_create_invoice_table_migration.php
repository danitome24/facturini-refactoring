<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateInvoiceTableMigration extends AbstractMigration
{
    private const TABLE_NAME = 'factura';

    public function up()
    {
        $this->table(self::TABLE_NAME, ['id' => 'num_reg'])
            ->addColumn('nom', 'string', ['length' => 255, 'default' => null])
            ->addColumn('adreca', 'string', ['length' => 255, 'default' => null])
            ->addColumn('nif', 'string', ['length' => 255, 'default' => null])
            ->addColumn('detalls', 'text')
            ->addColumn('factura', 'text')
            ->addColumn('observacions', 'text')
            ->addColumn('tipus', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => null, 'length' => 1])
            ->addColumn('fecha_solicitud', 'date', ['default' => null])
            ->addColumn('fecha', 'date', ['default' => null])
            ->addColumn('cobrada', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => null, 'length' => 1])
            ->addColumn('modificat', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'default' => null, 'length' => 1])
            ->create();
    }

    public function down()
    {
        $this->table(self::TABLE_NAME)->drop()->save();
    }
}
