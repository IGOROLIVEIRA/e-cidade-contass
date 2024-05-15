begin;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (3000272,'Teto Remuneratório', '','',1,1,'','t');

INSERT INTO db_menu VALUES (3000271,3000272,103,952);

INSERT INTO db_itensmenu VALUES (3000273,'Inclusão', '','pes1_tetoremuneratorio001.php',1,1,'','t');
INSERT INTO db_itensmenu VALUES (3000274,'Alteração', '','pes1_tetoremuneratorio002.php',1,1,'','t');
INSERT INTO db_itensmenu VALUES (3000275,'Exclusão', '','pes1_tetoremuneratorio003.php',1,1,'','t');

INSERT INTO db_menu VALUES (3000272,3000273,1,952);
INSERT INTO db_menu VALUES (3000272,3000274,2,952);
INSERT INTO db_menu VALUES (3000272,3000275,3,952);


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


commit;