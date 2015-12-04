--DROP TABLE:
DROP TABLE unidademedicos CASCADE;
--Criando drop sequences
DROP SEQUENCE unidademedicos_codigo_seq;


-- Criando  sequences
CREATE SEQUENCE unidademedicos_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: saude
CREATE TABLE unidademedicos(
sd04_i_codigo		int4 default 0,
sd04_i_unidade		int4 default 0,
sd04_i_medico		int4 default 0,
sd04_i_cbo		int4 default 0,
sd04_i_vinculo		int4 default 0,
sd04_i_tipovinc		int4 default 0,
sd04_i_subtipovinc		int4 default 0,
sd04_i_horaamb		int4 default 0,
sd04_i_horahosp		int4 default 0,
sd04_i_horaoutros		int4 default 0,
sd04_i_orgaoemissor		int4 default 0,
sd04_c_situacao		char(1) default 'A',
sd04_v_registroconselho		varchar(13) ,
sd04_c_sus		char(1) default 'N',
sd04_i_numerodias		int4 default 0,
sd04_d_folgaini		date default null,
sd04_d_folgafim		date default null,
CONSTRAINT unidademedicos_codi_pk PRIMARY KEY (sd04_i_codigo));




-- CHAVE ESTRANGEIRA


ALTER TABLE unidademedicos
ADD CONSTRAINT unidademedicos_vinculo_fk FOREIGN KEY (sd04_i_vinculo)
REFERENCES sau_modvinculo;

ALTER TABLE unidademedicos
ADD CONSTRAINT unidademedicos_orgaoemissor_fk FOREIGN KEY (sd04_i_orgaoemissor)
REFERENCES sau_orgaoemissor;

ALTER TABLE unidademedicos
ADD CONSTRAINT unidademedicos_medico_fk FOREIGN KEY (sd04_i_medico)
REFERENCES medicos;

ALTER TABLE unidademedicos
ADD CONSTRAINT unidademedicos_unidade_fk FOREIGN KEY (sd04_i_unidade)
REFERENCES unidades;




-- INDICES


CREATE UNIQUE INDEX unidademedicos_unid_med_in ON unidademedicos(sd04_i_unidade,sd04_i_medico);

