BEGIN;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS numeracaotipoproc CASCADE;
--Criando drop sequences


-- Criando  sequences
CREATE SEQUENCE numeracaotipoproc_p200_codigo_seq
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;
-- TABELAS E ESTRUTURA

-- Módulo: protocolo
CREATE TABLE numeracaotipoproc(
p200_codigo		int4 NOT NULL default 0,
p200_ano		int4 NOT NULL default 0,
p200_numeracao		int4 NOT NULL default 0,
p200_tipoproc		int4 default 0,
CONSTRAINT numeracaotipoproc_codi_pk PRIMARY KEY (p200_codigo));




-- CHAVE ESTRANGEIRA
alter table numeracaotipoproc add constraint numeracaotipoproc_p200_tipoproc_fk foreign key (p200_tipoproc) references tipoproc (p51_codigo);


alter table protprocesso add column p58_numeracao int4 NOT NULL default 0; 

commit;
