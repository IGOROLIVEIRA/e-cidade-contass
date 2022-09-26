<?php

use Phinx\Migration\AbstractMigration;

class Bugfixvarrel extends AbstractMigration
{

    public function up()
    {

        $sql="
        BEGIN;

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'dCriacao','date' ,'Data de cria��o m�s textual','', 'Data de cria��o m�s textual',16	,false, false, false, 0, 'date', 'Data de cria��o m�s textual');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1260, (select codcam from db_syscampo where nomecam = 'dCriacao'), (select max(seqarq)+1 from db_sysarqcamp where codarq = 1260), 0);
        
        COMMIT;
        ";
    }
}
