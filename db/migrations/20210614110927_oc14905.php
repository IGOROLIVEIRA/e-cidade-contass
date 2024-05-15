<?php

use Phinx\Migration\AbstractMigration;

class Oc14905 extends AbstractMigration
{
  public function up()
  {

    $sSql = <<<SQL

    BEGIN;

    update db_usuarios set senha= 'dc2b889f70a589acf415af55648f61a439fc38a6' where login = 'mhbc.contass';

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
    rel_corpo		varchar(8000) ,
    CONSTRAINT relatorios_sequ_pk PRIMARY KEY (rel_sequencial));

    -- CHAVE ESTRANGEIRA
    ALTER TABLE relatorios
    ADD CONSTRAINT relatorios_arquivo_fk FOREIGN KEY (rel_arquivo)
    REFERENCES db_sysarquivo;

    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_corpo                               ', 'varchar(500)                            ', 'Corpo', '', 'Corpo', 500, false, false, false, 0, 'text', 'Corpo');
    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_arquivo                              ', 'int4                                    ', 'Modulo', '0', 'Modulo', 10, false, false, false, 1, 'text', 'Modulo');
    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_descricao                           ', 'varchar(50)                             ', 'Descrição', '', 'Descrição', 50, false, false, false, 0, 'text', 'Descrição');
    INSERT INTO configuracoes.db_syscampo
    (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
    VALUES((select max(codcam)+1 from db_syscampo), 'rel_sequencial                          ', 'int4                                    ', 'Sequencial', '0', 'Sequencial', 10, false, false, false, 1, 'text', 'Sequencial');

    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_sequencial')		 	, 1, 0);
    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_descricao')		 	, 2, 0);
    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_arquivo')		 	, 3, 0);
    INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rel_corpo')		 	, 4, 0);



    -- MENU
    INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Gerenciamento de Relatórios', 'Gerenciamento de Relatórios', '', 1, 1, 'Gerenciamento de Relatórios', 't');

    INSERT INTO db_menu VALUES (32,
                        (SELECT max(id_item) FROM db_itensmenu),
                        (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32 and modulo = 1),
                        1);

    INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Cadastro', 'Cadastro', 'con1_relatorios001.php', 1, 1, 'Cadastro', 't');

    INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Gerenciamento de Relatórios'),
                        (SELECT max(id_item) FROM db_itensmenu),
                        (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32 and modulo = 1),
                        1);

    INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Gerador', 'Gerador', 'con1_relatorios002.php', 1, 1, 'Gerador', 't');

    INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Gerenciamento de Relatórios'),
                        (SELECT max(id_item) FROM db_itensmenu),
                        (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32 and modulo = 1),
                        1);
    --Licitação
    INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Gerador de relatórios', 'Gerador de relatórios', 'con1_relatorios002.php', 1, 1, 'Gerador de relatórios', 't');

    INSERT INTO db_menu VALUES (1797,
                        (SELECT max(id_item) FROM db_itensmenu),
                        (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 1797 and modulo = 381),
                        381);

    	-- Auto-generated SQL script #202106222154
      UPDATE configuracoes.db_modulos
        SET nome_manual='meioambiente'
        WHERE id_item=7808;
      UPDATE configuracoes.db_modulos
        SET nome_manual='custos'
        WHERE id_item=7029;
      UPDATE configuracoes.db_modulos
        SET nome_manual='docente'
        WHERE id_item=7836;
      UPDATE configuracoes.db_modulos
        SET nome_manual='gestor'
        WHERE id_item=7756;
      UPDATE configuracoes.db_modulos
        SET nome_manual='laboratorio'
        WHERE id_item=8167;
      UPDATE configuracoes.db_modulos
        SET nome_manual='hiperdia'
        WHERE id_item=9053;
      UPDATE configuracoes.db_modulos
        SET nome_manual='transporteescolar'
        WHERE id_item=7147;
      UPDATE configuracoes.db_modulos
        SET nome_manual='licitacao'
        WHERE id_item=381;
      UPDATE configuracoes.db_modulos
        SET nome_manual='esocial'
        WHERE id_item=10216;

        INSERT INTO public.relatorios
(rel_sequencial, rel_descricao, rel_arquivo, rel_corpo)
VALUES(31, 'AUTUAÇÃO', 1260, '<p>&nbsp;</p>
<p dir="ltr" style="line-height: 1.3800000000000001; text-align: center; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 18pt;"><strong><span style="font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">AUTUA&Ccedil;&Atilde;O</span></strong></span></p>
<p dir="ltr" style="line-height: 1.3800000000000001; text-align: center; margin-top: 0pt; margin-bottom: 10pt;">&nbsp;</p>
<p dir="ltr" style="line-height: 1.7999999999999998; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"> Tendo em vista a autoriza&ccedil;&atilde;o da autoridade competente para realiza&ccedil;&atilde;o de Licita&ccedil;&atilde;o para </span><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$l20_objeto#, o setor de licita&ccedil;&atilde;o da </span><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$sInstit#, declara que foi autuada a presente licita&ccedil;&atilde;o conforme a seguir:</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>PROCESSO</strong>: </span>#$l20_numero#</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>N&ordm; MODALIDADE</strong>:</span>#$l20_edital#</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>MODALIDADE</strong>: </span></span><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;">#$l03_descr#</span></p>
<p dir="ltr" style="line-height: 1.2; text-align: justify; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"><span style="color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;"><strong>DATA DE AUTUA&Ccedil;&Atilde;O</strong>: </span>#$datasistema#</span></p>
<p dir="ltr" style="line-height: 1.8; margin-top: 0pt; margin-bottom: 10pt; text-align: right;"><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$sMunicipio#, </span><span style="font-size: 14pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">#$dSistema#.</span></p>
<p>&nbsp;</p>
<p dir="ltr" style="line-height: 1.7999999999999998; margin-left: 36pt; text-align: center; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 12pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">______________________________</span></p>
<p dir="ltr" style="line-height: 1.7999999999999998; margin-left: 36pt; text-align: center; margin-top: 0pt; margin-bottom: 10pt;"><span style="font-size: 12pt; font-family: ''Times New Roman''; color: #000000; background-color: transparent; font-weight: 400; font-style: normal; font-variant: normal; text-decoration: none; vertical-align: baseline; white-space: pre-wrap;">Prefeito Municipal.</span></p>');
INSERT INTO public.relatorios
(rel_sequencial, rel_descricao, rel_arquivo, rel_corpo)
VALUES(30, 'AUTORIZAÇÃO', 1260, '<p dir="ltr">&nbsp;</p>
<p dir="ltr">&nbsp;</p>
<p id="docs-internal-guid-9a4297e9-7fff-d8da-5ab6-b60b3b08e9f8" dir="ltr" style="text-align: center;"><span style="font-size: 18pt; font-family: ''times new roman'', times, serif;"><strong>AUTORIZA&Ccedil;&Atilde;O</strong></span></p>
<p style="text-align: justify;"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: ''times new roman'', times, serif; font-size: 14pt;"> Estando cumpridas as formalidades previstas na Lei n&deg; 8.666/93, AUTORIZO a abertura do Procedimento Licitat&oacute;rio do tipo #$l03_descr#, para #$l20_objeto# , conforme Parecer Jur&iacute;dico e pre&ccedil;o m&eacute;dio em anexo, solicito de V.Sa. que seja autorizada nos moldes previstos no art. 37, inciso XXI da CF/88, disp&otilde;e sobre a obrigatoriedade de formalizar processo licitat&oacute;rio pr&eacute;vio &agrave; aquisi&ccedil;&atilde;o, nos moldes da Lei 8666/93 e suas altera&ccedil;&otilde;es.</span></p>
<p style="text-align: justify;"><span style="font-family: ''times new roman'', times, serif; font-size: 14pt;">Em atendimento ao disposto no inciso II do art. 16 da Lei Complementar n.&ordm; 101, de 05 de maio de 2000, declaro que a despesa tem adequa&ccedil;&atilde;o or&ccedil;ament&aacute;ria e financeira com a lei or&ccedil;ament&aacute;ria anual, compatibilidade com o plano plurianual e com a lei de diretrizes or&ccedil;ament&aacute;rias.&nbsp;</span></p>
<p style="text-align: justify;">&nbsp;</p>
<p>&nbsp;</p>
<p dir="ltr" style="text-align: right;"><span style="font-size: 14pt; font-family: ''times new roman'', times, serif;">#$sMunicipio#, #$dSistema#</span></p>
<p dir="ltr">&nbsp;</p>
<p dir="ltr">&nbsp;</p>
<p dir="ltr" style="text-align: center;">______________________________</p>
<p dir="ltr" style="text-align: center;"><span style="font-family: ''times new roman'', times, serif;">Prefeito Municipal.</span></p>');


SQL;

    $this->execute($sSql);
  }

  public function down()
  {
  }
}
