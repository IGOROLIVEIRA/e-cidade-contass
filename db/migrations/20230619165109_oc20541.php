<?php

use Phinx\Migration\AbstractMigration;

class Oc20541 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        BEGIN;
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_modalidade','int4' ,'Modalidade','', 'Nº Modalidade',11,false, false, false, 1, 'int4', 'Modalidade');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'licobraslicitacao'), (select codcam from db_syscampo where nomecam = 'obr07_modalidade'), 7, 0);
        
        ALTER TABLE licobraslicitacao ADD obr07_modalidade int;

        UPDATE db_syscampo SET aceitatipo = 1 WHERE nomecam = 'obr07_exercicio';

        COMMIT;

        ";

        $this->execute($sSql);
    }
}
