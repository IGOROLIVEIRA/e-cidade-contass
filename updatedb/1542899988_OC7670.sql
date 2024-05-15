
-- Ocorrência 7670
BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo V - Dem. da Disp. De Caixa e RP',
  'Anexo V - Dem. da Disp. De Caixa e RP',
  'con2_demodespcaixarp001.php', 1, 1,
  'Anexo V - Dem. da Disp. De Caixa e RP', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'RGF' and help = 'RGF 2018'), (select max(id_item) from db_itensmenu), 5, 209);

CREATE TABLE parametrosrelatoriosiconf(
c222_sequencial         int8 NOT NULL default 0,
c222_recimpostostranseduc       float8 NOT NULL default 0,
c222_transfundeb60              float8 NOT NULL default 0,
c222_transfundeb40              float8 NOT NULL default 0,
c222_recdestinadoeduc           float8 NOT NULL default 0,
c222_recimpostostranssaude      float8 NOT NULL default 0,
c222_recdestinadosaude          float8 NOT NULL default 0,
c222_recdestinadoassist         float8 NOT NULL default 0,
c222_recdestinadorppspp         float8 NOT NULL default 0,
c222_recdestinadorppspf         float8 NOT NULL default 0,
c222_recopcreditoexsaudeeduc    float8 NOT NULL default 0,
c222_recavaliacaodebens         float8 NOT NULL default 0,
c222_outrasdestinacoes          float8 NOT NULL default 0,
c222_recordinarios              float8 NOT NULL default 0,
c222_outrosrecnaovinculados     float8 NOT NULL default 0,
c222_anousu                     int4   NOT NULL);

CREATE SEQUENCE parametrosrelatoriosiconf_c222_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- Fim do script

COMMIT;

