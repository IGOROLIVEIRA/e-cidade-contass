<?php

use Phinx\Migration\AbstractMigration;

class Oc21481 extends AbstractMigration
{
    public function up()
    {
        $sSql = 
        "
        BEGIN;

        ALTER TABLE acordo ADD COLUMN ac16_vigenciaindeterminada int;

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_vigenciaindeterminada','int','Vigência Indeterminada','', 'Vigência Indeterminada',11,false, false, false, 1, 'int', 'Vigência Indeterminada');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'acordo'), (select codcam from db_syscampo where nomecam = 'ac16_vigenciaindeterminada'), 28, 0);

        COMMIT;
        
        ";

        $this->excute($sSql);
    }
}
