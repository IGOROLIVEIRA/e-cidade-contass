<?php

use Phinx\Migration\AbstractMigration;

class Addtablerhmotivoafasta extends AbstractMigration
{
    public function up()
    {
        $sql = "
        begin;
            -- INSERE db_sysarquivo
            INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'rhmotivoafasta','Motivos de Afastamentos eSocial','rh172','2019-12-21','Motivos de Afastamentos eSocial',0,'f','f','f','f');

            -- INSERE db_sysarqmod
            INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%pessoal%'), (select max(codarq) from db_sysarquivo));

            -- INSERE db_syscampo
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh172_sequencial','int8' ,'Sequencial','', 'Sequencial' ,11	,false, false, false, 1, 'int8', 'Sequencial');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh172_codigo','text' ,'Codigo Afastaemento','', 'Codigo Afastaemento' ,11	,false, false, false, 1, 'text', 'Codigo Afastaemento');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'rh172_descricao' ,'text' ,'Descrição Afastamento','', 'Descrição Afastamento' ,10	,false, false, false, 0, 'text', 'Descrição Afastamento');

            -- INSERE db_sysarqcamp
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh172_sequencial'), 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh172_codigo'), 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'rh172_descricao'), 3, 0);

            -- TABELAS E ESTRUTURA
            -- Módulo: Pessoal
            CREATE TABLE rhmotivoafasta(
                rh172_sequencial		 int8 NOT NULL,
                rh172_codigo			 varchar(14),
                rh172_descricao			 text);

            -- Criando  sequences
            CREATE SEQUENCE rhmotivoafasta_rh172_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            --inserindo menu cadastro de obras
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Cadastro de Motivos de Afastamentos eSocial','Cadastro de Motivos de Afastamentos eSocial','',1,1,'Cadastro de Motivos de Afastamentos eSocial','t');
            INSERT INTO db_menu VALUES(3516,(select max(id_item) from db_itensmenu),11,952);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','pes1_rhmotivoafasta001.php',1,1,'Inclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Motivos de Afastamentos eSocial%'),(select max(id_item) from db_itensmenu),1,952);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','pes1_rhmotivoafasta002.php',1,1,'Alteração','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Motivos de Afastamentos eSocial%'),(select max(id_item) from db_itensmenu),2,952);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','pes1_rhmotivoafasta003.php',1,1,'Exclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Motivos de Afastamentos eSocial%'),(select max(id_item) from db_itensmenu),3,952);
            
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'01', 'Acidente/doença do trabalho');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'03', 'Acidente/doença não relacionada ao trabalho');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'05', 'Afastamento/licença de servidor público prevista em estatuto, sem remuneração');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'06', 'Aposentadoria por invalidez');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'07', 'Acompanhamento-Licença para acompanhamento de membro da família enfermo');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'10', 'Afastamento/licença de servidor público prevista em estatuto, com remuneração');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'11', 'Cárcere');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'13', 'Cargo eletivo-Candidato a cargo eletivo');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'14', 'Cessão/Requisição');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'17', 'Licença maternidade');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'18', 'Licença maternidade-Prorrogação por 60 dias, Lei 11.770/2008 (Empresa Cidadã)');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'19', 'Licença maternidade-Afastamento temporário por motivo de aborto não criminoso');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'21', 'Licença não remunerada ou sem vencimento');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'22', 'Mandato eleitoral-Afastamento temporário para o exercício de mandato eleitoral');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'25', 'Mulher vítima de violência-Art. 9º, § 2º, inciso II, da Lei 11.340/2006-Lei Maria da Penha');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'29', 'Serviço militar-Afastamento temporário para prestar serviço militar obrigatório');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'35', 'Licença maternidade-Antecipação e/ou prorrogação mediante atestado médico');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'36', 'Afastamento temporário de exercente de mandato eletivo para cargo em comissão');
            insert into rhmotivoafasta values(nextval('rhmotivoafasta_rh172_sequencial_seq'),'40', 'Exercício em outro órgão de servidor ou empregado público cedido');

            alter table afasta ADD COLUMN r45_codigoafasta varchar(14);
            alter table afasta ADD COLUMN r45_mesmadoenca varchar(1);

        commit;
        ";
        $this->execute($sql);
    }
}
