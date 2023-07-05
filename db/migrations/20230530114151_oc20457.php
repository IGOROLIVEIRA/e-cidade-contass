<?php

use Phinx\Migration\AbstractMigration;

class Oc20457 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        begin;

        ALTER TABLE licitaparam ADD l12_validafornecedor_emailtel bool default false;

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l12_validafornecedor_emailtel','bool' ,'Validação de Fornecedor','', 'Validação de Fornecedor',1,false, false, false, 1, 'bool', 'Validação de Fornecedor');
 
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'licitaparam'), (select codcam from db_syscampo where nomecam = 'l12_validafornecedor_emailtel'), 6, 0);

        commit;";
        $this->execute($sSql);
    }
}
