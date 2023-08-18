<?php

use Phinx\Migration\AbstractMigration;

class Oc21015 extends AbstractMigration
{
    public function up()
    {
        $sSql = 
            "BEGIN;
            ALTER TABLE licitaparam ADD COLUMN l12_adjudicarprocesso bool default false;
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l12_adjudicarprocesso','bool' ,'Adjudicar Processo RP','', 'Adjudicar Processo RP',1,false, false, false, 1, 'bool', 'Adjudicar Processo RP');
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'licitaparam'), (select codcam from db_syscampo where nomecam = 'l12_adjudicarprocesso'), 7, 0);
            COMMIT;
        ";
        $this->execute($sSql);
    }
}
