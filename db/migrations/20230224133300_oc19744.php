<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc19744 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- INCLUI O TIPO DE DOCUMENTO 1040 - CABEÇALHO MODELO CARNÊ 30

        INSERT INTO configuracoes.db_tipodoc (db08_codigo, db08_descr) VALUES(1040, 'CABEÇALHO CARNÊ MODELO 30');               
                
        COMMIT;        

SQL;
        $this->execute($sql);
    }

}
