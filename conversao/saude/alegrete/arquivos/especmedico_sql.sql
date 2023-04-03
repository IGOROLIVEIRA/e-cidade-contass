--DROP TABLE:
DROP TABLE especmedico CASCADE;
--Criando drop sequences
--DROP SEQUENCE especmedico_i_codigo_seq;


-- Criando  sequences
CREATE SEQUENCE especmedico_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: saude
CREATE TABLE especmedico(
sd27_i_codigo		int4 default 0,
sd27_i_rhcbo		int4 default 0,
sd27_i_undmed		int4 default 0,
sd27_b_principal		bool default 'f',
CONSTRAINT especmedico_codi_pk PRIMARY KEY (sd27_i_codigo));




-- CHAVE ESTRANGEIRA


ALTER TABLE especmedico
ADD CONSTRAINT especmedico_rhcbo_fk FOREIGN KEY (sd27_i_rhcbo)
REFERENCES rhcbo;

ALTER TABLE especmedico
ADD CONSTRAINT especmedico_undmed_fk FOREIGN KEY (sd27_i_undmed)
REFERENCES unidademedicos;




-- INDICES


CREATE UNIQUE INDEX especmedico_undmed_rhcbo_in ON especmedico(sd27_i_undmed,sd27_i_rhcbo);

