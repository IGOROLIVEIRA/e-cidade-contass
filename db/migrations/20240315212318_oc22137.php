<?php

use Phinx\Migration\AbstractMigration;

class Oc22137 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        UPDATE db_itensmenu
        SET funcao='con4_gerarpca.php'
        WHERE descricao='Documentos DCASP Consolidado' and help='Contribuição' ;
        
        COMMIT;

SQL;
        $this->execute($sql);
    }
}