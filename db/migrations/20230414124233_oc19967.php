<?php

use Phinx\Migration\AbstractMigration;

class Oc19967 extends AbstractMigration
{

    public function up()
    {
        $sql =  "begin;

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Lançamento de Manutenção','Lançamento de Manutenção','',1,1,'Lançamento de Manutenção','t');
        
        INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),16,439);
        
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','pat1_lancmanutencao001.php',1,1,'Inclusão','t');
        
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Lançamento de Manutenção'),(select max(id_item) from db_itensmenu),1,439);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','pat1_lancmanutencao002.php',1,1,'Alteração','t');

INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Lançamento de Manutenção'),(select max(id_item) from db_itensmenu),2,439);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','pat1_lancmanutencao003.php',1,1,'Exclusão','t');

        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Lançamento de Manutenção'),(select max(id_item) from db_itensmenu),3,439);


        -- INSERE tabela no dicionario de dados
INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'bemmanutencao','Cadastro de Manutenção de Bens','t98','2023-04-18','Cadastro de Manutenção de Bens',0,'f','f','f','f');

-- INSERE CAMPOS
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_sequencial','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',11,false, false, false, 1, 'int8', 'Cód. Sequencial');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_bem','int8' ,'Cód. do Bem','', 'Cód. do Bem',11,false, false, false, 1, 'int8', 'Cód. do Bem');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_data','date' ,'Data','', 'Data',8,false, false, false, 1, 'date', 'Data');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_descricao','varchar(500)' ,'Descrição da Manutenção','', 'Descrição da Manutenção',10,false, false, false, 1, 'varchar(500)', 'Descrição da Manutenção');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_vlrmanut','float' ,'Valor da Manutenção','', 'Valor da Manutenção',15,false, false, false, 1, 'float', 'Valor da Manutenção');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_idusuario','int' ,'Id do Usuario','', 'Usuario',10,false, false, false, 1, 'int', 'Usuario');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_dataservidor','date' ,'Data da Manutenção','', 'Data da Manutenção',8,false, false, false, 1, 'date', 'Data da Manutenção');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_horaservidor','time' ,'Horario da Manutenção','', 'Horario da Manutenção',8,false, false, false, 1, 'time', 'Horario da Manutenção');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_tipo','int4' ,'Tipo da Manutenção','', 'Tipo da Manutenção',5,false, false, false, 1, 'int4', 'Tipo da Manutenção');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_manutencaoprocessada','bool' ,'Manutenção Processada','f', 'Manutenção Processada',1,false, false, false, 1, 'bool', 'Manutenção Processada');



-- INSERE VINCULO DO CAMPO COM A TABELA
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_sequencial'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_bem'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_data'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_descricao'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_vlrmanut'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_idusuario'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_dataservidor'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_horaservidor'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_tipo'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_manutencaoprocessada'), 10, 0);


CREATE TABLE bemmanutencao (
	t98_sequencial int8 not null
    ,t98_bem int NOT NULL 
    ,t98_data date not null
    ,t98_descricao  varchar(500) not null
    ,t98_vlrmanut float not null
    ,t98_idusuario int not null
    ,t98_dataservidor date not null
    ,t98_horaservidor time not null
    ,t98_tipo int4 not null
    ,t98_manutencaoprocessada bool not null default false);
        
       
CREATE SEQUENCE bemmanutencao_t98_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


ALTER TABLE bemmanutencao ADD PRIMARY KEY (t98_sequencial);

ALTER TABLE bemmanutencao ADD CONSTRAINT bemmanutencao_patrimonio_fk
FOREIGN KEY (t98_bem) REFERENCES bens (t52_bem);


-- INSERE tabela no dicionario de dados
INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'manutbensitem','Componentes da manutenção de bens','t99','2023-04-20','Componentes da manutenção de bens',0,'f','f','f','f');

-- INSERE CAMPOS
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_sequencial','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',11,false, false, false, 1, 'int8', 'Cód. Sequencial');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_itemsistema','int4' ,'Item do Sistema','', 'Item do Sistema',11,false, false, false, 1, 'int4', 'Item do Sistema');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_valor','float' ,'Valor do Item','', 'Valor do Item',8,false, false, false, 1, 'float', 'Valor do Item');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_descricao','varchar(200)' ,'Descrição do Item','', 'Descrição da Item',200,false, false, false, 1, 'varchar(200)', 'Descrição do Item');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_codpcmater','int4' ,'Codigo pcmater','', 'Codigo pcmater',11,false, false, false, 1, 'int4', 'Codigo pcmater');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_codbensdispensatombamento','int4' ,'Codigo bensdispensatombamento','', 'Codigo bensdispensatombamento',11,false, false, false, 1, 'int4', 'Codigo bensdispensatombamento');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't99_codbemmanutencao','int4' ,'Codigo bemmanutencao','', 'Codigo bemmanutencao',11,false, false, false, 1, 'int4', 'Codigo bemmanutencao');

-- INSERE VINCULO DO CAMPO COM A TABELA
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_sequencial'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_itemsistema'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_valor'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_descricao'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_codpcmater'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_codbensdispensatombamento'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't99_codbemmanutencao'), 7, 0);


CREATE TABLE manutbensitem (
	t99_sequencial int8 not null
    ,t99_itemsistema int4 NOT NULL 
    ,t99_valor float not null
    ,t99_descricao  varchar(200) not null
    ,t99_codpcmater int null
    ,t99_codbensdispensatombamento int null
    ,t99_codbemmanutencao int not null);
        
       
CREATE SEQUENCE manutbensitem_t99_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


ALTER TABLE manutbensitem ADD PRIMARY KEY (t99_sequencial);

ALTER TABLE manutbensitem ADD CONSTRAINT manutbensitem_t99_codpcmater_fk FOREIGN KEY(t99_codpcmater) REFERENCES pcmater (pc01_codmater);
ALTER TABLE manutbensitem ADD CONSTRAINT manutbensitem_t99_codbensdispensatombamento_fk FOREIGN KEY(t99_codbensdispensatombamento) REFERENCES bensdispensatombamento (e139_sequencial);
ALTER TABLE manutbensitem ADD CONSTRAINT manutbensitem_t99_codbemmanutencao_fk FOREIGN KEY(t99_codbemmanutencao) REFERENCES bemmanutencao (t98_sequencial);



        
        
        commit;";

        $this->execute($sql);
    }
}
