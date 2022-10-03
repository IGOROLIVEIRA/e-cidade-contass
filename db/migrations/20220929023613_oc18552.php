<?php

use Phinx\Migration\AbstractMigration;

class Oc18552 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        BEGIN;

        INSERT INTO db_syscampo 
        VALUES ((select max(codcam)+1 from db_syscampo),'l20_dataaberproposta', 'date', 'Data Abertura Proposta','','Data Abertura Proposta',10,false,false,false,0,'date','Data Abertura Proposta');

        INSERT INTO db_syscampo 
        VALUES ((select max(codcam)+1 from db_syscampo),'l20_dataencproposta', 'date', 'Data de Encerramento Proposta','','Data de Encerramento Proposta',10,false,false,false,0,'date','Data de Encerramento Proposta');

        ALTER TABLE liclicita ADD l20_dataaberproposta date null;

        ALTER TABLE liclicita ADD l20_dataencproposta date null;
        
        COMMIT;
        ";

        $this->execute($sql);
    }
}
