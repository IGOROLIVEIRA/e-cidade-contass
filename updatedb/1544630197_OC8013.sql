
-- Ocorrência 8013
BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Despesas inscritas em RP',
  'Despesas inscritas em RP',
  'con2_despesainscritarp001.php', 1, 1,
  'Despesas inscritas em RP', 't');

INSERT INTO db_menu VALUES (3332, (select max(id_item) from db_itensmenu), 206, 209);

ALTER TABLE iderp112018 DROP CONSTRAINT iderp112018_reg10_fk;

 CREATE TABLE despesasinscritasRP(
 c223_sequencial      int8 NOT NULL default 0,
 c223_codemp          int8 NOT NULL default 0,
 c223_credor          text NOT NULL default 0,
 c223_fonte           int8 NOT NULL default 0,
 c223_vlrnaoliquidado float8 NOT NULL default 0,
 c223_vlrliquidado    float8 NOT NULL default 0,
 c223_vlrdisRPNP      float8 NOT NULL default 0,
 c223_vlrdisRPP       float8 NOT NULL default 0,
 c223_vlrsemdisRPNP   float8 NOT NULL default 0,
 c223_vlrsemdisRPP    float8 NOT NULL default 0,
 c223_vlrdisptotal    float8 NOT NULL default 0,
 c223_vlrutilizado    float8 NOT NULL default 0,
 c223_vlrdisponivel   float8 NOT NULL default 0,
 c223_anousu          int4   NOT NULL,
 c223_instit          int4   NOT NULL
 );

 CREATE SEQUENCE despesasinscritasRP_c223_sequencial_seq
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- Fim do script

COMMIT;

