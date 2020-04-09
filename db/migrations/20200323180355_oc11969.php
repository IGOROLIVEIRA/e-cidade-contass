<?php

use Phinx\Migration\AbstractMigration;

class Oc11969 extends AbstractMigration
{

    public function up()
    {
        $sql = "BEGIN;

        UPDATE db_estruturavalor
        SET db121_descricao = '(VETADO)'
        WHERE db121_estrutural = '14.14';

        DELETE
        FROM issconfiguracaogruposervico
        WHERE EXISTS
                (SELECT 1
                 FROM issgruposervico
                 WHERE EXISTS
                         (SELECT 1
                          FROM db_estruturavalor
                          WHERE db121_estrutural = '14.14'
                              AND db121_sequencial = q126_db_estruturavalor)
                     AND q136_issgruposervico = q126_sequencial)
            AND q136_exercicio = 2020";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "UPDATE db_estruturavalor
        SET db121_descricao = 'Guincho intramunicipal, guindaste e içamento.'
        WHERE db121_estrutural = '14.14';";
        $this->execute($sql);
    }
}
