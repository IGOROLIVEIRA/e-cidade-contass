
-- Ocorrência 6160
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE conplano ADD COLUMN c60_cgmpessoa integer;
ALTER TABLE conplano ADD CONSTRAINT conplano_cgmpessoa_fk 
FOREIGN KEY (c60_cgmpessoa) REFERENCES cgm(z01_numcgm);


CREATE TABLE balancete262018 (
    si193_sequencial bigint DEFAULT 0 NOT NULL,
    si193_tiporegistro bigint DEFAULT 0 NOT NULL,
    si193_contacontabil bigint DEFAULT 0 NOT NULL,
    si193_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
    si193_tipodocumentopessoaatributosf integer,
    si193_nrodocumentopessoaatributosf varchar(14),
    si193_atributosf character varying(1) NOT NULL,
    si193_saldoinicialpessoaatributosf double precision DEFAULT 0 NOT NULL,
    si193_naturezasaldoinicialpessoaatributosf character varying(1) NOT NULL,
    si193_totaldebitospessoaatributosf double precision DEFAULT 0 NOT NULL,
    si193_totalcreditospessoaatributosf double precision DEFAULT 0 NOT NULL,
    si193_saldofinalpessoaatributosf double precision DEFAULT 0 NOT NULL,
    si193_naturezasaldofinalpessoaatributosf character varying(1) NOT NULL,
    si193_mes bigint DEFAULT 0 NOT NULL,
    si193_instit bigint DEFAULT 0,
    si193_reg10 bigint NOT NULL
);


ALTER TABLE balancete262018 OWNER TO dbportal;

CREATE SEQUENCE balancete262018_si193_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete262018_si193_sequencial_seq OWNER TO dbportal;

ALTER TABLE ONLY balancete262018
    ADD CONSTRAINT balancete262018_sequ_pk PRIMARY KEY (si193_sequencial);

ALTER TABLE ONLY balancete262018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si193_reg10) REFERENCES balancete102018(si177_sequencial);


-- Fim do script

COMMIT;

