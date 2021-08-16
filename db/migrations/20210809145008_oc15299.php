<?php

use Classes\PostgresMigration;

class Oc15299 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE rhvinculodotpatronais 
            ADD COLUMN rh171_programaorig INTEGER,
            ADD COLUMN rh171_programanov INTEGER,
            ADD COLUMN rh171_funcaoorig INTEGER,
            ADD COLUMN rh171_funcaonov INTEGER,
            ADD COLUMN rh171_subfuncaoorig INTEGER,
            ADD COLUMN rh171_subfuncaonov INTEGER;

        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_programaorig', 	'int8', 'Programa', '0', 'Programa', 11, false, false, false, 1, 'text', 'Programa');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_programanov', 	'int8', 'Programa', '0', 'Programa', 11, false, false, false, 1, 'text', 'Programa');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_funcaoorig', 	'int8', 'Função', '0', 'Função', 11, false, false, false, 1, 'text', 'Função');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_funcaonov', 'int8', 'Função', '0', 'Função', 11, false, false, false, 1, 'text', 'Função');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_subfuncaoorig', 	'int8', 'Subfunção', '0', 'Subfunção', 11, false, false, false, 1, 'text', 'Subfunção');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_subfuncaonov','int8', 'Subfunção', '0', 'Subfunção', 11, false, false, false, 1, 'text', 'Subfunção');

        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_programaorig'), 13, (select codsequencia from db_syssequencia where nomesequencia = 'rhvinculodotpatronais_rh171_sequencial_seq'));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_programanov'), 14, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_funcaoorig'), 15, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_funcaonov'), 16, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_subfuncaoorig'), 17, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_subfuncaonov'), 18, 0);

        COMMIT;

SQL;
    $this->execute($sql);
  }

}