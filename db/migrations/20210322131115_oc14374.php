<?php

use Classes\PostgresMigration;

class Oc14374 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;

        SELECT fc_startsession();

        INSERT INTO db_syscampo
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k29_cotaunicafundeb', 'bool', 'Conta única FUNDEB', 'f', 'Conta única FUNDEB', 1, FALSE, FALSE, FALSE, 5, 'text', 'Conta única FUNDEB');


        INSERT INTO db_sysarqcamp
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'caiparametro'),  
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'k29_cotaunicafundeb'),  
            (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'caiparametro')), 0);

        ALTER TABLE caiparametro ADD COLUMN k29_cotaunicafundeb boolean DEFAULT false;
        
        COMMIT;

SQL;
        $this->execute($sql);
    }

}