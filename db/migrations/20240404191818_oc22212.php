<?php

use Phinx\Migration\AbstractMigration;

class Oc22212 extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        
        BEGIN;
        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'liclancedital','lancamento edital','l47','2024-04-04','lancamento edital',0,'f','f','f','f');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l47_dataenvio','date' ,'Data de Envio','', 'Data de Envio',10	,false, false, false, 1, 'date', 'Data de Envio');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l47_dataenvio'), 1, 0);
        COMMIT;
        ";

        $this->execute($sSql);
    }
}
