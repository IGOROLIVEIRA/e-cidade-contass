--Cria tabela vinculopcasptce
begin;
select fc_startsession();
CREATE TABLE contabilidade.vinculopcasptce
(
  c209_pcaspestrut character varying(9) NOT NULL,
  c209_tceestrut character varying(9) NOT NULL
);
ALTER TABLE contabilidade.vinculopcasptce
  OWNER TO dbportal;
ALTER TABLE vinculopcasptce ADD CONSTRAINT vinculopcasptce_c209_pcaspestrut_c209_tceestrut UNIQUE (c209_pcaspestrut,c209_tceestrut);

commit;