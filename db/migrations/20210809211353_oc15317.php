<?php

use Phinx\Migration\AbstractMigration;

class Oc15317 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_tipcatprof','int4','Categoria Profissional SIOPE', 0, 'Categoria Profissional SIOPE', 10, 't', 't', 'f', 1, 'text', 'Categoria Profissional SIOPE');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art61ldb1 boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art61ldb1','boolean','Professores habilitados em nível médio ou superior para docência na educação infantil e nos ensinos fundamental e médio', 0, 'Professores habilitados em nível médio ou superior', 1, 'f', 'f', 'f', NULL, NULL, 'Professores habilitados em nível médio');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art61ldb2 boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art61ldb2','boolean','Trabalhadores em educação portadores de diploma de pedagogia, com habilitação em administração, planejamento, supervisão, inspeção e orientação educacional, bem como com títulos de mestrado ou doutorado nas mesmas áreas', 0, 'Trabalhadores em educação portadores de diploma', 1, 'f', 'f', 'f', NULL, NULL, 'Trabalhadores em educação portadores');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art61ldb3 boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art61ldb3','boolean','Trabalhadores em educação portadores de diploma de curso técnico ou superior em área pedagógica ou afim', 0, 'Trabalhadores em educação portadores de diploma', 1, 'f', 'f', 'f', NULL, NULL, 'Trabalhadores em educação portadores');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art61ldb4 boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art61ldb4','boolean','Profissionais com notório saber reconhecido pelos respectivos sistemas de ensino, para ministrar conteúdos de áreas afins à sua formação ou experiência profissional, atestados por titulação específica ou prática de ensino em unidades educacionais da rede pública ou privada ou das corporações privadas em que tenham atuado, exclusivamente para atender ao inciso V do caput do art. 36', 0, 'Profissionais com notório saber reconhecido pelos', 1, 'f', 'f', 'f', NULL, NULL, 'Profissionais com notório saber reconhec');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art61ldb5 boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art61ldb5','boolean','Profissionais graduados que tenham feito complementação pedagógica, conforme disposto pelo Conselho Nacional de Educação', 0, 'Profissionais graduados que tenham feito complemen', 1, 'f', 'f', 'f', NULL, NULL, 'Profissionais graduados que tenham feito');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art1leiprestpsiccologia boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art1leiprestpsiccologia','boolean','Prestação de serviços em psicologia', 0, 'Prestação de serviços em psicologia', 1, 'f', 'f', 'f', NULL, NULL, 'Prestação de serviços em psicologia');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));

        ALTER TABLE rhpessoalmov ADD COLUMN rh02_art1leiprestservsocial boolean default false;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'rh02_art1leiprestservsocial','boolean','Prestação de serviços em serviço social', 0, 'Prestação de serviços em serviço social', 1, 'f', 'f', 'f', NULL, NULL, 'Prestação de serviços em serviço social');
        INSERT INTO db_sysarqcamp VALUES (1158, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=1158));
        ";
        $this->execute($sSql);
    }

    public function down() 
    {
        $sSql = "
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_tipcatprof');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_tipcatprof';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art61ldb1;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art61ldb1');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art61ldb1';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art61ldb2;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art61ldb2');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art61ldb2';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art61ldb3;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art61ldb3');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art61ldb3';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art61ldb4;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art61ldb4');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art61ldb4';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art61ldb5;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art61ldb5');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art61ldb5';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art1leiprestpsiccologia;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art1leiprestpsiccologia');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art1leiprestpsiccologia';

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_art1leiprestservsocial;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_art1leiprestservsocial');
        DELETE fROM db_syscampo WHERE nomecam = 'rh02_art1leiprestservsocial';
        ";

        $this->execute($sSql);
    }
}
