<?php

use Phinx\Migration\AbstractMigration;

class Oc14118complementar extends AbstractMigration
{

    public function up()
    {
        $this->execute("
        INSERT INTO issgruposervico
        SELECT nextval('issgruposervico_q126_sequencial_seq'),
               db121_sequencial
        FROM db_estruturavalor
        WHERE db121_db_estrutura = 150000
          AND db121_estrutural = '16.02'
          AND NOT EXISTS
            (SELECT 1
             FROM issgruposervico
             WHERE q126_db_estruturavalor = db121_sequencial);
        ");
    }
}
