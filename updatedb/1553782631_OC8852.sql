BEGIN;

DROP TABLE IF EXISTS public.aoc152019;

CREATE TABLE public.aoc152019 (
	si194_sequencial int8 NOT NULL DEFAULT 0,
	si194_tiporegistro int8 NOT NULL DEFAULT 0,
	si194_codreduzidodecreto int8 NOT NULL DEFAULT 0,
	si194_origemrecalteracao varchar(2) NOT NULL,
	si194_codorigem int8 NOT NULL DEFAULT 0,
	si194_codorgao varchar(2) NOT NULL,
	si194_codunidadesub varchar(8) NOT NULL,
	si194_codfuncao varchar(2) NOT NULL,
	si194_codsubfuncao varchar(3) NOT NULL,
	si194_codprograma varchar(4) NOT NULL,
	si194_idacao varchar(4) NOT NULL,
	si194_idsubacao varchar(4) NULL DEFAULT NULL::character varying,
	si194_naturezadespesa int8 NOT NULL DEFAULT 0,
	si194_codfontrecursos int8 NOT NULL DEFAULT 0,
	si194_vlreducao float8 NOT NULL DEFAULT 0,
	si194_mes int8 NOT NULL DEFAULT 0,
	si194_reg10 int8 NOT NULL DEFAULT 0,
	si194_instit int8 NOT NULL DEFAULT 0,
	CONSTRAINT aoc152019_sequ_pk PRIMARY KEY (si194_sequencial),
	CONSTRAINT aoc152019_reg10_fk FOREIGN KEY (si194_reg10) REFERENCES aoc102019(si38_sequencial)
)
WITH (
	OIDS=TRUE
);
CREATE INDEX aoc152019_si194_reg10_index ON aoc152019 USING btree (si194_reg10);

-- Permissions

ALTER TABLE public.aoc152019 OWNER TO dbportal;
GRANT ALL ON TABLE public.aoc152019 TO dbportal;

COMMIT;