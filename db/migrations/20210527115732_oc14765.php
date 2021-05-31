<?php

use Classes\PostgresMigration;

class Oc14765 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2021,
               704,
            (SELECT codigo
             FROM db_config
             WHERE prefeitura = 't');

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 704
                  AND c45_anousu = 2021
                LIMIT 1), 
               9701,
               'PRIMEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'PRIMEIRO LANCAMENTO',
               1);
               
        COMMIT;

SQL;

        $this->execute($sql);
    }

}