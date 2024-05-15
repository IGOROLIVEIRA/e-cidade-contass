<?php

use Phinx\Migration\AbstractMigration;

class Oc17075 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art61ldboutros boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art61ldboutros','boolean','Outros', 0, 'Outros', 1, 'f', 'f', 'f', NULL, NULL, 'Outros');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art1leioutros boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art1leioutros','boolean','Outros', 0, 'Outros', 1, 'f', 'f', 'f', NULL, NULL, 'Outros');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));
        ";
        $this->execute($sSql);
    }

    public function down() 
    {
        $sSql = "
        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art61ldboutros;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art61ldboutros');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art61ldboutros';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art1leioutros;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art1leioutros');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art1leioutros';
        ";

        $this->execute($sSql);
    }
}
