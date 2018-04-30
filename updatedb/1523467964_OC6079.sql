
BEGIN;
SELECT fc_startsession();

-- Início do script

--DROP TABLE:
DROP TABLE IF EXISTS autprotpagordem CASCADE;
DROP TABLE IF EXISTS autprotslip CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS autprotpagordem_p107_sequencial_seq;
DROP SEQUENCE IF EXISTS autprotslip_p108_sequencial_seq;

-- Criando  sequences
CREATE SEQUENCE autprotpagordem_p107_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE autprotslip_p108_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA

-- M�dulo: protocolo
CREATE TABLE autprotpagordem(
p107_sequencial   int4 NOT NULL default 0,
p107_autorizado   bool NOT NULL default 'f',
p107_codord   int4 NOT NULL default 0,
p107_protocolo    int4 NOT NULL default 0,
p107_dt_cadastro    date default null,
CONSTRAINT autprotpagordem_sequ_pk PRIMARY KEY (p107_sequencial));


-- M�dulo: protocolo
CREATE TABLE autprotslip(
p108_sequencial   int4 NOT NULL default 0,
p108_autorizado   bool NOT NULL default 'f',
p108_slip   int4 NOT NULL default 0,
p108_protocolo    int4 NOT NULL default 0,
p108_dt_cadastro    date default null,
CONSTRAINT autprotslip_sequ_pk PRIMARY KEY (p108_sequencial));

-- CHAVE ESTRANGEIRA

ALTER TABLE autprotpagordem
ADD CONSTRAINT autprotpagordem_protocolo_fk FOREIGN KEY (p107_protocolo)
REFERENCES protocolos;

ALTER TABLE autprotpagordem
ADD CONSTRAINT autprotpagordem_codord_fk FOREIGN KEY (p107_codord)
REFERENCES pagordem;

ALTER TABLE autprotslip
ADD CONSTRAINT autprotslip_slip_fk FOREIGN KEY (p108_slip)
REFERENCES slip;

ALTER TABLE autprotslip
ADD CONSTRAINT autprotslip_protocolo_fk FOREIGN KEY (p108_protocolo)
REFERENCES protocolos;

-- INDICES

CREATE UNIQUE INDEX p107_sequencial_index ON autprotpagordem(p107_sequencial);

CREATE UNIQUE INDEX p108_sequencial_index ON autprotslip(p108_sequencial);

-- Fim do script

COMMIT;


