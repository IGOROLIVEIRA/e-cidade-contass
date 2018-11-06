
-- Ocorrência terem2019
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table tetoremuneratorio add column te01_codteto int4;

-- drop table CREATE TABLE terem102019;

CREATE TABLE terem102019 (
    si194_sequencial          bigint DEFAULT 0            NOT NULL
      constraint terem102019_sequ_pk
      primary key,
    si194_tiporegistro        bigint DEFAULT 0            NOT NULL,
    si194_cnpj                varchar(14),
    si194_codteto             bigint DEFAULT 0,
    si194_vlrparateto         double precision DEFAULT 0  NOT NULL,
    si194_tipocadastro        bigint DEFAULT 0            NOT NULL,
    si194_dtinicial           date                        NOT NULL,
    si194_nrleiteto           bigint DEFAULT 0            NOT NULL,
    si194_dtpublicacaolei     date                        NOT NULL,
    si194_dtfinal             date,
    si194_justalteracao       varchar(250),
    si194_mes                 bigint DEFAULT 0            NOT NULL,
    si194_inst                bigint DEFAULT 0
);

-- Fim do script

COMMIT;

