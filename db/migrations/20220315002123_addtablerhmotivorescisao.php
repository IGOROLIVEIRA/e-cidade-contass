<?php

use Phinx\Migration\AbstractMigration;

class Addtablerhmotivorescisao extends AbstractMigration
{
    public function up()
    {
        $sql = "
        begin;
            -- INSERE db_sysarquivo
            INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'rhmotivorescisao','Motivos de Rescis�o eSocial','rh173','2019-12-21','Motivos de Rescis�o eSocial',0,'f','f','f','f');

            -- INSERE db_sysarqmod
            INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%pessoal%'), (select max(codarq) from db_sysarquivo));

            -- INSERE db_syscampo
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh173_sequencial','int8' ,'Sequencial','', 'Sequencial' ,11	,false, false, false, 1, 'int8', 'Sequencial');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh173_codigo','text' ,'Codigo Afastaemento','', 'Codigo Afastaemento' ,11	,false, false, false, 1, 'text', 'Codigo Afastaemento');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh173_descricao' ,'text' ,'Descri��o Afastamento','', 'Descri��o Afastamento' ,10	,false, false, false, 0, 'text', 'Descri��o Afastamento');

            -- INSERE db_sysarqcamp
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh173_sequencial'), 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh173_codigo'), 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh173_descricao'), 3, 0);

            -- TABELAS E ESTRUTURA
            -- M�dulo: Pessoal
            CREATE TABLE rhmotivorescisao(
                rh173_sequencial		 int8 NOT NULL,
                rh173_codigo			 varchar(14),
                rh173_descricao			 text);

            -- Criando  sequences
            CREATE SEQUENCE rhmotivorescisao_rh173_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            --inserindo menu cadastro de obras
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Cadastro de Motivos de Rescis�o eSocial','Cadastro de Motivos de Rescis�o eSocial','',1,1,'Cadastro de Motivos de Rescis�o eSocial','t');
            INSERT INTO db_menu VALUES(3516,(select max(id_item) from db_itensmenu),11,952);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclus�o','Inclus�o','pes1_rhmotivorescisao001.php',1,1,'Inclus�o','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Motivos de Rescis�o eSocial%'),(select max(id_item) from db_itensmenu),1,952);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Altera��o','Altera��o','pes1_rhmotivorescisao002.php',1,1,'Altera��o','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Motivos de Rescis�o eSocial%'),(select max(id_item) from db_itensmenu),2,952);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclus�o','Exclus�o','pes1_rhmotivorescisao003.php',1,1,'Exclus�o','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Motivos de Rescis�o eSocial%'),(select max(id_item) from db_itensmenu),3,952);

            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'01', 'Acidente/doen�a do trabalho');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'03', 'Acidente/doen�a n�o relacionada ao trabalho');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'05', 'Afastamento/licen�a de servidor p�blico prevista em estatuto, sem remunera��o');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'06', 'Aposentadoria por invalidez');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'07', 'Acompanhamento-Licen�a para acompanhamento de membro da fam�lia enfermo');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'10', 'Afastamento/licen�a de servidor p�blico prevista em estatuto, com remunera��o');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'11', 'C�rcere');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'13', 'Cargo eletivo-Candidato a cargo eletivo');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'14', 'Cess�o/Requisi��o');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'17', 'Licen�a maternidade');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'18', 'Licen�a maternidade-Prorroga��o por 60 dias, Lei 11.770/2008 (Empresa Cidad�)');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'19', 'Licen�a maternidade-Afastamento tempor�rio por motivo de aborto n�o criminoso');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'21', 'Licen�a n�o remunerada ou sem vencimento');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'22', 'Mandato eleitoral-Afastamento tempor�rio para o exerc�cio de mandato eleitoral');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'25', 'Mulher v�tima de viol�ncia-Art. 9�, � 2�, inciso II, da Lei 11.340/2006-Lei Maria da Penha');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'29', 'Servi�o militar-Afastamento tempor�rio para prestar servi�o militar obrigat�rio');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'35', 'Licen�a maternidade-Antecipa��o e/ou prorroga��o mediante atestado m�dico');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'36', 'Afastamento tempor�rio de exercente de mandato eletivo para cargo em comiss�o');
            insert into rhmotivorescisao values(nextval('rhmotivorescisao_rh173_sequencial_seq'),'40', 'Exerc�cio em outro �rg�o de servidor ou empregado p�blico cedido');

            alter table rescisao ADD COLUMN r45_codigorescisao varchar(14);
            alter table rescisao ADD COLUMN r45_mesmadoenca varchar(1);

        commit;
        ";
        $this->execute($sql);
    }
}
