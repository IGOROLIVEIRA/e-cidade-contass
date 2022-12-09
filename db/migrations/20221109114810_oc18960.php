<?php

use Phinx\Migration\AbstractMigration;

class Oc18960 extends AbstractMigration
{

    public function up()
    {
        $sql = "BEGIN;";
        $sql .=
            "INSERT INTO db_syscampo 
        VALUES ((select max(codcam)+1 from db_syscampo),'l20_orcsigiloso', 'bool', 'Valor Estimado Sigiloso',
        '','Valor Estimado Sigiloso',10,false,false,false,0,'text','Valor Estimado Sigiloso');
        
        ALTER TABLE liclicita ADD l20_orcsigiloso bool null;";
        $sql .= " COMMIT;";

        $this->execute($sql);
    }
}
