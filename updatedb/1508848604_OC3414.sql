
-- Ocorrência 3414

begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS empenhosexcluidos CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS empenhosexcluidos_e290_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE empenhosexcluidos_e290_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- M�dulo: empenho
CREATE TABLE empenhosexcluidos(
e290_sequencial   int4 NOT NULL default 0,
e290_e60_numemp   int4 NOT NULL default 0,
e290_e60_codemp   varchar(15) NOT NULL ,
e290_e60_anousu   int4 NOT NULL default 0,
e290_e60_vlremp   float8 NOT NULL default 0,
e290_e60_emiss    date NOT NULL default null,
e290_z01_numcgm   int4 NOT NULL default 0,
e290_z01_nome   varchar(40) NOT NULL ,
e290_id_usuario   int4 NOT NULL default 0,
e290_nomeusuario    varchar(40) NOT NULL ,
e290_dtexclusao   date NOT NULL,
CONSTRAINT empenhosexcluidos_sequ_pk PRIMARY KEY (e290_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE empenhosexcluidos
ADD CONSTRAINT empenhosexcluidos_usuario_fk FOREIGN KEY (e290_id_usuario)
REFERENCES db_usuarios;

ALTER TABLE empenhosexcluidos
ADD CONSTRAINT empenhosexcluidos_numcgm_fk FOREIGN KEY (e290_z01_numcgm)
REFERENCES cgm;




-- INDICES


CREATE UNIQUE INDEX e290_sequencial ON empenhosexcluidos(e290_sequencial);

commit;

