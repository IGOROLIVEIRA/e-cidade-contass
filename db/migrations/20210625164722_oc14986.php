<?php

use Classes\PostgresMigration;

class Oc14986 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'De/Para Dotações Patronais', 'De/Para Dotações Patronais','',1,1,'De/Para Dotações Patronais','t');
        INSERT INTO db_menu VALUES (29, (select max(id_item) from db_itensmenu), (select max(menusequencia) from db_menu where id_item = 29 and modulo = 952)+1, 952);

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Inclusão', 'Inclusão','pes1_rhvinculodotpatronais001.php',1,1,'Inclusão','t');
        INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu where descricao = 'De/Para Dotações Patronais'), (select max(id_item) from db_itensmenu), 1, 952);

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Alteração', 'Alteração','pes1_rhvinculodotpatronais002.php',1,1,'Alteração','t');
        INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu where descricao = 'De/Para Dotações Patronais'), (select max(id_item) from db_itensmenu), 2, 952);

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Exclusão', 'Exclusão','pes1_rhvinculodotpatronais003.php',1,1,'Exclusão','t');
        INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu where descricao = 'De/Para Dotações Patronais'), (select max(id_item) from db_itensmenu), 3, 952);

        CREATE TABLE pessoal.rhvinculodotpatronais(
            rh171_sequencial	INTEGER NOT NULL DEFAULT 0,
            rh171_orgaoorig		INTEGER NOT NULL DEFAULT 0,
            rh171_orgaonov		INTEGER NOT NULL DEFAULT 0,
            rh171_unidadeorig	INTEGER NOT NULL DEFAULT 0,
            rh171_unidadenov	INTEGER NOT NULL DEFAULT 0,
            rh171_projativorig	INTEGER NOT NULL DEFAULT 0,
            rh171_projativnov	INTEGER NOT NULL DEFAULT 0,
            rh171_recursoorig	INTEGER NOT NULL DEFAULT 0,
            rh171_recursonov	INTEGER NOT NULL DEFAULT 0,
            rh171_mes			INTEGER NOT NULL DEFAULT 0,
            rh171_anousu		INTEGER NOT NULL DEFAULT 0,
            rh171_instit		INTEGER NOT NULL DEFAULT 0,
            CONSTRAINT rhvinculodotpatronais_rh171_sequencial_pk PRIMARY KEY (rh171_sequencial)
        );

        CREATE SEQUENCE rhvinculodotpatronais_rh171_sequencial_seq
                                                        INCREMENT 1
                                                        MINVALUE 1
                                                        MAXVALUE 9223372036854775807
                                                        START 154
                                                        CACHE 1;

        -- INSERINDO db_sysarquivo
        INSERT INTO configuracoes.db_sysarquivo VALUES ((select max(codarq)+1 from db_sysarquivo), 'rhvinculodotpatronais', 'De/Para Dotações Patronais', 'rh171', '2021-06-25', 'De/Para Dotações Patronais', 0, false, false, false, false);
                
        -- INSERINDO db_sysarqmod
        INSERT INTO configuracoes.db_sysarqmod VALUES (28, (select max(codarq) from db_sysarquivo));
        
        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_sequencial', 	'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_orgaoorig', 	'int8', 'Órgão', '0', 'Órgão', 11, false, false, false, 1, 'text', 'Órgão');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_orgaonov', 	'int8', 'Órgão', '0', 'Órgão', 11, false, false, false, 1, 'text', 'Órgão');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_unidadeorig', 'int8', 'Unidade', '0', 'Unidade', 11, false, false, false, 1, 'text', 'Unidade');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_unidadenov', 	'int8', 'Unidade', '0', 'Unidade', 11, false, false, false, 1, 'text', 'Unidade');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_projativorig','int8', 'Projetos/Atividades', '0', 'Projetos/Atividades', 11, false, false, false, 1, 'text', 'Projetos/Atividades');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_projativnov', 'int8', 'Projetos/Atividades', '0', 'Projetos/Atividades', 11, false, false, false, 1, 'text', 'Projetos/Atividades');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_recursoorig', 'int8', 'Recurso', '0', 'Recurso', 11, false, false, false, 1, 'text', 'Recurso');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_recursonov', 	'int8', 'Recurso', '0', 'Recurso', 11, false, false, false, 1, 'text', 'Recurso');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_mes', 		'int8', 'Mês', '0', 'Mês', 11, false, false, false, 1, 'text', 'Mês');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_anousu', 		'int8', 'Ano', '0', 'Ano', 11, false, false, false, 1, 'text', 'Ano');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh171_instit', 		'int8', 'Instituição', '0', 'Instituição', 11, false, false, false, 1, 'text', 'Instituição');

        -- INSERINDO db_syssequencia
        INSERT INTO configuracoes.db_syssequencia VALUES ((select max(codsequencia)+1 from db_syssequencia), 'rhvinculodotpatronais_rh171_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'rhvinculodotpatronais_rh171_sequencial_seq'));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_orgaoorig'), 2, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_orgaonov'), 3, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_unidadeorig'), 4, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_unidadenov'), 5, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_projativorig'), 6, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_projativnov'), 7, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_recursoorig'), 8, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_recursonov'), 9, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_mes'), 10, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_anousu'), 11, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhvinculodotpatronais'), (select codcam from db_syscampo where nomecam = 'rh171_instit'), 12, 0);

        COMMIT;

SQL;

    $this->execute($sql);

  }

}
