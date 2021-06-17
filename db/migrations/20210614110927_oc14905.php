<?php

use Phinx\Migration\AbstractMigration;

class Oc14905 extends AbstractMigration
{
  public function up()
  {

    $sSql = <<<SQL

    BEGIN;

    update db_usuarios set senha= 'dc2b889f70a589acf415af55648f61a439fc38a6' where login = 'mhbc.contass'

    CREATE SEQUENCE configuracoes.db_syssequencia_codsequencia_se
      INCREMENT BY 1
      MINVALUE 1
      MAXVALUE 9223372036854775807
      START 1;

    --DROP TABLE:
    DROP TABLE IF EXISTS relatorios CASCADE;
    --Criando drop sequences
    DROP SEQUENCE IF EXISTS relatorios_rel_sequencial_seq;


    -- Criando  sequences
    CREATE SEQUENCE relatorios_rel_sequencial_seq
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;


    -- TABELAS E ESTRUTURA

    -- Módulo: configuracoes
    CREATE TABLE relatorios(
    rel_sequencial		int4 NOT NULL default 0,
    rel_descricao		varchar(50) NOT NULL ,
    rel_arquivo		int4 NOT NULL default 0,
    rel_corpo		varchar(500) ,
    CONSTRAINT relatorios_sequ_pk PRIMARY KEY (rel_sequencial));

    -- CHAVE ESTRANGEIRA
    ALTER TABLE relatorios
    ADD CONSTRAINT relatorios_arquivo_fk FOREIGN KEY (rel_arquivo)
    REFERENCES db_sysarquivo;

    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_corpo                               ', 'varchar(500)                            ', 'Corpo', '', 'Corpo', 500, false, true, false, 0, 'text', 'Corpo');
    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_arquivo                              ', 'int4                                    ', 'Modulo', '0', 'Modulo', 10, false, false, false, 1, 'text', 'Modulo');
    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_descricao                           ', 'varchar(50)                             ', 'Descrição', '', 'Descrição', 50, false, true, false, 0, 'text', 'Descrição');
    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_sequencial                          ', 'int4                                    ', 'Sequencial', '0', 'Sequencial', 10, false, false, false, 1, 'text', 'Sequencial');

    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_sequencial')		 	, 1, 0);
    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_descricao')		 	, 2, 0);
    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_arquivo')		 	, 3, 0);
    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_corpo')		 	, 4, 0);



    -- MENU
    INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Gerenciamento de Contratos', 'Gerenciamento de Contratos', 'con1_relatorios001.php', 1, 1, 'Gerenciamento de Contratos', 't');

    INSERT INTO db_menu VALUES (32,
                    (SELECT max(id_item) FROM db_itensmenu),
                    (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32 and modulo = 1),
                    1);
SQL;

    $this->execute($sSql);
  }

  public function down()
  {
  }
}
