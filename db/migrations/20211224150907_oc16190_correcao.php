<?php

use Phinx\Migration\AbstractMigration;

class Oc16190Correcao extends AbstractMigration
{
    public function up()
    {  

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        DELETE FROM db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam = 'k81_regrepasse');
        
        INSERT INTO db_sysarqcamp 
                (codarq, codcam, seqarq, codsequencia) 
        VALUES 
                ((select codarq from db_sysarquivo where nomearq = 'placaixarec'),
                (select codcam from db_syscampo where nomecam = 'k81_regrepasse'), 14, 0);
        COMMIT; 
SQL;
        $this->execute($sql);
    }
}
