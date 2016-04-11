select fc_startsession();
BEGIN;
CREATE TABLE licitacao.regulamentalc123
(
  l210_sequencial bigint NOT NULL DEFAULT 0,
  l210_regulamentart47 bigint NOT NULL DEFAULT 0,
  l210_nronormareg character varying(6),
  l210_datanormareg date,
  l210_datapubnormareg date,
  l210_regexclusiva bigint DEFAULT 0,
  l210_artigoregexclusiva character varying(6),
  l210_valorlimiteregexclusiva double precision NOT NULL DEFAULT 0,
  l210_procsubcontratacao bigint DEFAULT 0,
  l210_artigoprocsubcontratacao character varying(6),
  l210_percentualsubcontratacao double precision NOT NULL DEFAULT 0,
  l210_criteriosempenhopagamento bigint DEFAULT 0,
  l210_artigoempenhopagamento character varying(6),
  l210_estabeleceuperccontratacao bigint DEFAULT 0,
  l210_artigoperccontratacao character varying(6),
  l210_percentualcontratacao double precision NOT NULL DEFAULT 0,
  l210_instit bigint DEFAULT 0,
  CONSTRAINT l210_sequencial_seq_pk PRIMARY KEY (l210_sequencial)
)
WITH (
  OIDS=TRUE
);
ALTER TABLE licitacao.regulamentalc123
  OWNER TO dbportal;


CREATE SEQUENCE licitacao.regulamentalc123_l210_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 2
  CACHE 1;
ALTER TABLE licitacao.regulamentalc123_l210_sequencial_seq
  OWNER TO dbportal;


commit;