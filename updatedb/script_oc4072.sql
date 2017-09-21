begin;
select fc_startsession();

--DROP TABLE:
DROP TABLE IF EXISTS transferenciaveiculos CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS transferenciaveiculos_ve80_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE transferenciaveiculos_ve80_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: veiculos
CREATE TABLE transferenciaveiculos(
ve80_sequencial   int4 default 0,
ve80_motivo varchar(150) NOT NULL,
ve80_dt_transferencia date NOT NULL,
ve80_id_usuario int4 NOT NULL default 0,
ve80_coddeptoatual int4 default 0,
ve80_coddeptodestino int4 default 0,
CONSTRAINT transferenciaveiculos_sequ_pk PRIMARY KEY (ve80_sequencial));


-- CHAVE ESTRANGEIRA


ALTER TABLE transferenciaveiculos
ADD CONSTRAINT transferenciaveiculos_coddeptoatual_fk FOREIGN KEY (ve80_coddeptoatual)
REFERENCES db_depart;

ALTER TABLE transferenciaveiculos
ADD CONSTRAINT transferenciaveiculos_coddeptodestino_fk FOREIGN KEY (ve80_coddeptodestino)
REFERENCES db_depart;

ALTER TABLE transferenciaveiculos
ADD CONSTRAINT transferenciaveiculos_usuario_fk FOREIGN KEY (ve80_id_usuario)
REFERENCES db_usuarios;

-- INDICES


CREATE UNIQUE INDEX ve80_sequencial ON transferenciaveiculos(ve80_sequencial);

----------------------------------------------------------------------------------------------------------------------------------

--DROP TABLE:
DROP TABLE IF EXISTS veiculostransferencia CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS veiculostransferencia_ve81_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE veiculostransferencia_ve81_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: veiculos
CREATE TABLE veiculostransferencia(
ve81_sequencial   int4 default 0,
ve81_codigo   int4 default 0,
ve81_codigoant   int4 default 0,
ve81_placa character varying(7),
ve81_codunidadesubatual character varying(8),
ve81_codunidadesubant character varying(8),
ve81_transferencia int4 default 0,
CONSTRAINT veiculostransferencia_sequ_pk PRIMARY KEY (ve81_sequencial));

-- CHAVE ESTRANGEIRA

ALTER TABLE veiculostransferencia
ADD CONSTRAINT veiculostransferencia_transferencia_fk FOREIGN KEY (ve81_transferencia)
REFERENCES transferenciaveiculos;

ALTER TABLE veiculostransferencia
ADD CONSTRAINT veiculostransferencia_codigo_fk FOREIGN KEY (ve81_codigo)
REFERENCES veiculos;

-- INDICES

CREATE UNIQUE INDEX ve81_sequencial ON veiculostransferencia(ve81_sequencial);


commit;


