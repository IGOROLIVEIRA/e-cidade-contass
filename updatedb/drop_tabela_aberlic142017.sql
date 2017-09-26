-- Table: aberlic142017

DROP TABLE aberlic142017;

CREATE TABLE aberlic142017
(
  si50_sequencial bigint NOT NULL DEFAULT 0,
  si50_tiporegistro bigint NOT NULL DEFAULT 0,
  si50_codorgaoresp character varying(2) NOT NULL,
  si50_codunidadesubresp character varying(8) NOT NULL,
  si50_exerciciolicitacao bigint NOT NULL DEFAULT 0,
  si50_nroprocessolicitatorio character varying(12) NOT NULL,
  si50_nrolote bigint DEFAULT 0,
  si50_coditem bigint NOT NULL DEFAULT 0,
  si50_dtcotacao date NOT NULL,
  si50_vlrefpercentual float4 NOT NULL DEFAULT 0,
  si50_vlcotprecosunitario double precision NOT NULL DEFAULT 0,
  si50_quantidade double precision NOT NULL DEFAULT 0,
  si50_vlminalienbens double precision NOT NULL DEFAULT 0,
  si50_mes bigint NOT NULL DEFAULT 0,
  si50_reg10 bigint NOT NULL DEFAULT 0,
  si50_instit bigint DEFAULT 0,

  CONSTRAINT aberlic142017_sequ_pk PRIMARY KEY (si50_sequencial),
  CONSTRAINT aberlic142017_reg10_fk FOREIGN KEY (si50_reg10)
      REFERENCES aberlic102017 (si46_sequencial) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=TRUE
);
ALTER TABLE aberlic142017
  OWNER TO dbportal;

-- Index: aberlic142017_si50_reg10_index

-- DROP INDEX aberlic142017_si50_reg10_index;

CREATE INDEX aberlic142017_si50_reg10_index
  ON aberlic142017
  USING btree
  (si50_reg10);