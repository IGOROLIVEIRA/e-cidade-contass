<?php

use Phinx\Migration\AbstractMigration;

class Oc15732correcao extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
            delete from db_paragrafo where db02_descr like 'HOMOLOGACACAO RELATORIO';
            delete from db_documento where db03_descr like 'HOMOLOGACACAO RELATORIO'; 
            delete from db_documentopadrao where db60_descr like 'HOMOLOGACACAO RELATORIO';
            delete from db_tipodoc where db08_descr like 'HOMOLOGACACAO RELATORIO';       

            delete from db_paragrafo where db02_descr like 'ADJUDICACAO RELATORIO';
            delete from db_documento where db03_descr like 'ADJUDICACAO RELATORIO'; 
            delete from db_documentopadrao where db60_descr like 'ADJUDICACAO RELATORIO';
            delete from db_tipodoc where db08_descr like 'ADJUDICACAO RELATORIO'; 

        COMMIT;

SQL;

        $this->execute($sql);
    }
}
