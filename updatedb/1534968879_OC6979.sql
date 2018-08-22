
-- Ocorrência 6979
BEGIN;
SELECT fc_startsession();

-- Início do script

--adicionando o campo c60_naturezadareceita na tabela conplano
ALTER TABLE conplano ADD COLUMN c60_naturezadareceita int8;

--criando tabela do registro 25 do sicombalacete
CREATE TABLE balancete252018
(
  si194_sequencial bigint NOT NULL DEFAULT 0,
  si194_tiporegistro bigint NOT NULL DEFAULT 0,
  si194_contacontabil bigint NOT NULL DEFAULT 0,
  si194_codfundo character varying(8) NOT NULL DEFAULT '00000000'::character varying,
  si194_atributosf character varying(1) NOT NULL,
  si194_naturezareceita bigint NOT NULL DEFAULT 0,
  si194_saldoinicialsf double precision NOT NULL DEFAULT 0,
  si194_naturezasaldoinicialsf character varying(1) NOT NULL,
  si194_totaldebitossf double precision NOT NULL DEFAULT 0,
  si194_totalcreditossf double precision NOT NULL DEFAULT 0,
  si194_saldofinalsf double precision NOT NULL DEFAULT 0,
  si194_naturezasaldofinalsf character varying(1) NOT NULL,
  si194_mes bigint NOT NULL DEFAULT 0,
  si194_instit bigint DEFAULT 0,
  si194_reg10 bigint NOT NULL,
  CONSTRAINT balancete252018_sequ_pk PRIMARY KEY (si194_sequencial),
  CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si194_reg10)
      REFERENCES balancete102018 (si177_sequencial) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=TRUE
);


ALTER TABLE balancete252018
  OWNER TO dbportal;

-- criar sequente da tabela

CREATE SEQUENCE balancete252018_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;



-- Fim do script

COMMIT;

