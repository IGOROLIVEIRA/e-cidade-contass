begin;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (3000272,'Teto Remuneratório', '','',1,1,'','t');

INSERT INTO db_menu VALUES (3000271,3000272,103,952);

INSERT INTO db_itensmenu VALUES (3000275,'Inclusão', '','pes1_tetoremuneratorio001.php',1,1,'','t');
INSERT INTO db_itensmenu VALUES (3000276,'Alteração', '','pes1_tetoremuneratorio002.php',1,1,'','t');
INSERT INTO db_itensmenu VALUES (3000277,'Exclusão', '','pes1_tetoremuneratorio003.php',1,1,'','t');

INSERT INTO db_menu VALUES (3000272,3000275,1,952);
INSERT INTO db_menu VALUES (3000272,3000276,2,952);
INSERT INTO db_menu VALUES (3000272,3000277,3,952);


--DROP TABLE:
DROP TABLE IF EXISTS tetoremuneratorio CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS tetoremuneratorio_te01_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE tetoremuneratorio_te01_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: pessoal
CREATE TABLE tetoremuneratorio(
te01_sequencial		int4 NOT NULL default 0,
te01_valor		float4 NOT NULL default 0,
te01_tipocadastro		int4 NOT NULL default 0,
te01_dtinicial		date NOT NULL default null,
te01_dtfinal		date NOT NULL default null,
te01_justificativa		varchar(250) ,
CONSTRAINT tetoremuneratorio_sequ_pk PRIMARY KEY (te01_sequencial));




-- CHAVE ESTRANGEIRA





-- INDICES


update db_itensmenu set descricao = 'Proventos', help = 'Proventos', funcao = 'pes1_rhbasesproventos006.php' where id_item = 3000269;
insert into db_itensmenu values (3000278,'Descontos','Descontos','pes1_rhbasesdescontos006.php',1,1,'','t');
insert into db_menu values (3000268,3000278,2,952);

commit;