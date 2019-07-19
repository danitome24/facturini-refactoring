<?php

use Phinx\Migration\AbstractMigration;

class CreateDatabaseMigration extends AbstractMigration
{
    public function up()
    {
        $databaseName = getenv('PHINX_MYSQL_DATABASE');
        if ($this->getAdapter()->hasDatabase($databaseName)) {
            return;
        }

        $options = [
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
        ];
        $this->createDatabase($databaseName, $options);
    }

    public function down()
    {
        $databaseName = getenv('PHINX_MYSQL_DATABASE');
        $this->dropDatabase($databaseName);
    }
}
