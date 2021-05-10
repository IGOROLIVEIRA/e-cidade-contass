<?php

use Classes\PostgresMigration;

class Oc14655 extends PostgresMigration
{

    public function up()
    {
        $sSql = "
        ALTER TABLE rhpessoalmov ADD COLUMN rh02_segatuacao integer;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_segatuacao','int4','Segmento de Atuação', 0, 'Segmento de Atuação', 10, 't', 't', 'f', 1, 'text', 'Segmento de Atuação');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));
        ";
        $this->execute($sSql);
    }

    public function down()
    {
        $sSql = "
        ALTER TABLE rhpessoalmov DROP COLUMN rh02_segatuacao;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_segatuacao');
        DELETE FROM db_syscampo WHERE nomecam = 'rh02_segatuacao';
        ";
        $this->execute($sSql);
    }
}
