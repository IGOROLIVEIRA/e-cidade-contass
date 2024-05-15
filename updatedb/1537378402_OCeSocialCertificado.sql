-- Ocorrência eSocialCertificado
BEGIN;                   
SELECT fc_startsession();

-- Início do script

-- Criando  sequences
CREATE SEQUENCE esocialcertificado_rh214_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA

-- Modulo: esocial
CREATE TABLE esocialcertificado(
rh214_sequencial                int8 NOT NULL default 0,
rh214_cgm            int8 NOT NULL default 0,
rh214_senha             varchar(50) NOT NULL ,
rh214_certificado               text ,
rh214_instit            int8 NOT NULL default 0,
CONSTRAINT esocialcertificado_sequ_pk PRIMARY KEY (rh214_sequencial),
UNIQUE (rh214_cgm,rh214_instit));


-- CHAVE ESTRANGEIRA
ALTER TABLE esocialcertificado
ADD CONSTRAINT esocialcertificado_instit_fk FOREIGN KEY (rh214_instit)
REFERENCES db_config;

-- CHAVE ESTRANGEIRA
ALTER TABLE esocialcertificado
ADD CONSTRAINT esocialcertificado_cgm_fk FOREIGN KEY (rh214_cgm)
REFERENCES cgm;

-- Fim do script

COMMIT;

