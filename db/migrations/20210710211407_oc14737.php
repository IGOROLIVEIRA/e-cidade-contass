<?php

use Phinx\Migration\AbstractMigration;

class Oc14737 extends AbstractMigration
{
    public function up()
    {

        $sSql = "
        ALTER TABLE rhrubricas ADD COLUMN rh27_codincidprev int8;
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidprev) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh27_codincidprev','int(11)','Cod. incidência tributária previdência social', '', 'Cod. incidência tributária previdência social', 11, 't', 'f', 'f', 1, 'text', 'Cod. incidência previdência social');
        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas'), (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=(SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas')));

        ALTER TABLE rhrubricas ADD COLUMN rh27_codincidirrf int8;
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidirrf) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh27_codincidirrf','int(11)','Cod. incidência tributária irrf', '', 'Cod. incidência tributária irrf', 11, 't', 'f', 'f', 1, 'text', 'Cod. incidência tributária irrf');
        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas'), (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=(SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas')));

        ALTER TABLE rhrubricas ADD COLUMN rh27_codincidfgts int8;
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidfgts) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh27_codincidfgts','int(11)','Cod. incidência para o fgts', '', 'Cod. incidência para o fgts', 11, 't', 'f', 'f', 1, 'text', 'Cod. incidência para o fgts');
        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas'), (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=(SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas')));

        ALTER TABLE rhrubricas ADD COLUMN rh27_codincidregime int8;
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidregime) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh27_codincidregime','int(11)','Cod. incidência Regime Próprio RPPS/regime militar', '', 'Cod. incidência Regime Próprio RPPS/regime militar', 11, 't', 'f', 'f', 1, 'text', 'Cod. incid Reg Próprio RPPS/reg. militar');
        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas'), (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=(SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas')));

        ALTER TABLE rhrubricas ADD COLUMN rh27_tetoremun Boolean;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh27_tetoremun','boolean','Teto remuneratório (art. 37, XI, da CF/1988)', NULL, 'Teto remuneratório (art. 37, XI, da CF/1988)', 1, 'f', 't', 'f', 0, 'boolean', 'Teto remun(art. 37, XI, da CF/1988)');
        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas'), (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=(SELECT codarq FROM db_sysarquivo WHERE nomearq='rhrubricas')));
        ";
        $this->execute($sSql);
    }

    public function down()
    {
        $sSql = "
        ALTER TABLE rhrubricas DROP COLUMN rh27_codincidprev;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh27_codincidprev');
        DELETE fROM db_syscampo WHERE nomecam = 'rh27_codincidprev';

        ALTER TABLE rhrubricas DROP COLUMN rh27_codincidirrf;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh27_codincidirrf');
        DELETE fROM db_syscampo WHERE nomecam = 'rh27_codincidirrf';

        ALTER TABLE rhrubricas DROP COLUMN rh27_codincidfgts;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh27_codincidfgts');
        DELETE fROM db_syscampo WHERE nomecam = 'rh27_codincidfgts';

        ALTER TABLE rhrubricas DROP COLUMN rh27_codincidregime;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh27_codincidregime');
        DELETE fROM db_syscampo WHERE nomecam = 'rh27_codincidregime';

        ALTER TABLE rhrubricas DROP COLUMN rh27_tetoremun;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh27_tetoremun');
        DELETE fROM db_syscampo WHERE nomecam = 'rh27_tetoremun';
        ";
        $this->execute($sSql);
    }
}
