<?php

use Classes\PostgresMigration;

class Oc14036 extends PostgresMigration
{

    public function up()
    {

        $sSql = "
        ALTER TABLE inssirf ADD COLUMN r33_rubmat13 char(4);
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'r33_rubmat13','varchar(4)','Rubrica do salário maternidade 13º', '', 'Rubrica do salário maternidade 13º', 4, 't', 't', 'f', 0, 'text', 'Rubrica do salário maternidade 13º');
        INSERT INTO db_sysarqcamp VALUES (561, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=561));
        ";
        $this->execute($sSql);
    }

    public function down()
    {
        $sSql = "
        ALTER TABLE inssirf DROP COLUMN r33_rubmat13;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'r33_rubmat13');
        DELETE fROM db_syscampo WHERE nomecam = 'r33_rubmat13';
        ";
        $this->execute($sSql);
    }
}
