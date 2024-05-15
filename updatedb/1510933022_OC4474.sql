
-- Ocorrência 4474
begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protslip CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protslip_p106_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE protslip_p106_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: protocolo
CREATE TABLE protslip(
p106_sequencial   int4 NOT NULL default 0,
p106_slip   int4 NOT NULL default 0,
p106_protocolo    int4 default 0,
CONSTRAINT protslip_sequ_pk PRIMARY KEY (p106_sequencial));




-- CHAVE ESTRANGEIRA

ALTER TABLE protslip
ADD CONSTRAINT protslip_slip_fk FOREIGN KEY (p106_slip)
REFERENCES slip;

ALTER TABLE protslip
ADD CONSTRAINT protslip_protocolo_fk FOREIGN KEY (p106_protocolo)
REFERENCES protocolos;




-- INDICES

CREATE UNIQUE INDEX p106_sequencial_index ON protslip(p106_sequencial);

commit;

