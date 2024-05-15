/*
-- Ocorrência 8580
BEGIN;
SELECT fc_startsession();

-- Início do script

CREATE TABLE ide2019 (
    si11_sequencial               bigint DEFAULT 0  NOT NULL
      constraint ide2019_sequ_pk
      primary key,
    si11_codmunicipio             varchar(5)        NOT NULL,
    si11_cnpjmunicipio            varchar(14)       NOT NULL,
    si11_codorgao                 varchar(3)        NOT NULL,
    si11_tipoorgao                varchar(2)        NOT NULL,
    si11_exercicioreferencia      bigint DEFAULT 0  NOT NULL,
    si11_mesreferencia            varchar(2)        NOT NULL,
    si11_datageracao              date              NOT NULL,
    si11_codcontroleremessa       varchar(20),
    si11_mes                      bigint DEFAULT 0  NOT NULL,
    si11_instit                   bigint DEFAULT 0
);

ALTER TABLE ide2019 OWNER TO dbportal;
CREATE SEQUENCE ide2019_si11_sequencial_seq;
ALTER SEQUENCE ide2019_si11_sequencial_seq owner to dbportal;

CREATE TABLE pessoa102019 (
    si12_sequencial                   bigint DEFAULT 0 NOT NULL
      constraint pessoa102019_sequ_pk
      primary key,
    si12_tiporegistro                 bigint DEFAULT 0 NOT NULL,
    si12_tipodocumento                bigint DEFAULT 0 NOT NULL,
    si12_nrodocumento                 varchar(14)      NOT NULL,
    si12_nomerazaosocial              varchar(120)     NOT NULL,
    si12_tipocadastro                 bigint default 0 NOT NULL,
    si12_justificativaalteracao       varchar(100),
    si12_mes                          bigint DEFAULT 0 NOT NULL,
    si12_instit                       bigint DEFAULT 0
);

ALTER TABLE pessoa102019 OWNER TO dbportal;
CREATE SEQUENCE pessoa102019_si12_sequencial_seq;
ALTER SEQUENCE pessoa102019_si12_sequencial_seq OWNER TO dbportal;

CREATE TABLE viap102019 (
    si198_sequencial                 integer DEFAULT 0 NOT NULL
      constraint viap102019_sequ_pk
      primary key,
    si198_tiporegistro               integer DEFAULT 0 NOT NULL,
    si198_nrocpfagentepublico        varchar(11)       NOT NULL,
    si198_codmatriculapessoa         integer default 0 NOT NULL,
    si198_codvinculopessoa           integer DEFAULT 0 NOT NULL,
    si198_mes                        integer DEFAULT 0 NOT NULL,
    si198_instit                     integer DEFAULT 0
);

ALTER TABLE viap102019 OWNER TO dbportal;
CREATE SEQUENCE viap102019_si198_sequencial_seq;
ALTER SEQUENCE viap102019_si198_sequencial_seq OWNER TO dbportal;

create table afast102019(
  si199_sequencial                  integer default 0 not null
    constraint afast102019_sequ_pk
    primary key,
  si199_tiporegistro                integer default 0 not null,
  si199_codvinculopessoa            integer default 0 not null,
  si199_codafastamento              integer default 0 not null,
  si199_dtinicioafastamento         date              not null,
  si199_dtretornoafastamento        date              not null,
  si199_tipoafastamento             integer default 0 not null,
  si199_dscoutrosafastamentos       varchar(500),
  si199_mes                         integer default 0 not null,
  si199_inst                        integer default 0
);

ALTER TABLE afast102019 OWNER TO dbportal;
CREATE SEQUENCE afast102019_si199_sequencial_seq;
ALTER SEQUENCE afast102019_si199_sequencial_seq OWNER TO dbportal;

create table afast202019(
  si200_sequencial                  integer default 0 not null
    constraint afast202019_sequ_pk
    primary key,
  si200_tiporegistro                integer default 0 not null,
  si200_codvinculopessoa            integer default 0 not null,
  si200_codafastamento              integer default 0 not null,
  si200_dtterminoafastamento        date              not null,
  si200_mes                         integer default 0 not null,
  si200_inst                        integer default 0
);

ALTER TABLE afast202019 OWNER TO dbportal;
CREATE SEQUENCE afast202019_si200_sequencial_seq;
ALTER SEQUENCE afast202019_si200_sequencial_seq OWNER TO dbportal;

create table afast302019(
  si201_sequencial                  integer default 0 not null
    constraint afast302019_sequ_pk
    primary key,
  si201_tiporegistro                integer default 0 not null,
  si201_codvinculopessoa            integer default 0 not null,
  si201_codafastamento              integer default 0 not null,
  si201_dtretornoafastamento        date              not null,
  si201_mes                         integer default 0 not null,
  si201_inst                        integer default 0
);

ALTER TABLE afast302019 OWNER TO dbportal;
CREATE SEQUENCE afast302019_si201_sequencial_seq;
ALTER SEQUENCE afast302019_si201_sequencial_seq OWNER TO dbportal;

create table terem202019(
  si196_sequencial                  bigint default 0            not null
    constraint terem202019_sequ_pk     
    primary key,     
  si196_tiporegistro                bigint default 0            not null,
  si196_codteto                     bigint default 0                    not null,
  si196_vlrparateto                 double precision default 0  not null,
  si196_nrleiteto                   bigint default 0            not null,
  si196_dtpublicacaolei             date                        not null,
  si196_justalteracaoteto           varchar(250),
  si196_mes                         bigint default 0            not null,
  si196_inst                        bigint default 0
);

ALTER TABLE terem202019 owner to dbportal;
CREATE SEQUENCE terem202019_si196_sequencial_seq;
ALTER SEQUENCE terem202019_si196_sequencial_seq OWNER TO dbportal;

create table flpgo102019(
  si195_sequencial                      bigint default 0 not null
    constraint flpgo102019_sequ_pk
    primary key,
  si195_tiporegistro                    bigint ,
  si195_codvinculopessoa                bigint ,
  si195_regime                          varchar(1) ,
  si195_indtipopagamento                varchar(1) ,
  si195_dsctipopagextra                 varchar(150),
  si195_indsituacaoservidorpensionista  varchar(1) ,
  si195_nrocpfinstituidor               varchar(11),
  si195_datobitoinstituidor             date,
  si195_tipodependencia                 bigint,
  si195_dscsituacao                     varchar(150),
  si195_datconcessaoaposentadoriapensao date,
  si195_dsccargo                        varchar(120),
  si195_codcargo                        bigint,
  si195_sglcargo                        varchar(3),
  si195_dscsiglacargo                   varchar(150),
  si195_dscapo                          varchar(3),
  si195_natcargo                        integer,
  si195_dscnatcargo                     varchar(150),
  si195_indcessao                       varchar(3),
  si195_dsclotacao                      varchar(250),
  si195_indsalaaula                     varchar(1),
  si195_vlrcargahorariasemanal          bigint,
  si195_datefetexercicio                date,
  si195_datcomissionado                 date,
  si195_datexclusao                     date,
  si195_datcomissionadoexclusao         date,
  si195_vlrremuneracaobruta             double precision,
  si195_vlrdescontos                    double precision,
  si195_vlrremuneracaoliquida           double precision,
  si195_natsaldoliquido                 varchar(1),
  si195_mes                             bigint,
  si195_inst                            bigint
);

ALTER TABLE flpgo102019 owner to dbportal;
CREATE SEQUENCE flpgo102019_si195_sequencial_seq;
ALTER SEQUENCE flpgo102019_si195_sequencial_seq OWNER TO dbportal;

CREATE TABLE flpgo112019 (
    si196_sequencial                  bigint DEFAULT 0 NOT NULL
      constraint flpgo112019_sequ_pk
      primary key,
    si196_tiporegistro                bigint,
    si196_indtipopagamento            varchar(1),
    si196_codvinculopessoa            varchar(15),
    si196_codrubricaremuneracao       varchar(4),
    si196_desctiporubrica             varchar(150),
    si196_vlrremuneracaodetalhada     double precision,
    si196_reg10                       bigint default 0
      constraint flpgo112019_reg10_fk
      references flpgo102019,
    si196_mes                         bigint,
    si196_inst                        bigint
);

ALTER TABLE flpgo112019 OWNER TO dbportal;
CREATE SEQUENCE flpgo112019_si196_sequencial_seq;
ALTER SEQUENCE flpgo112019_si196_sequencial_seq OWNER TO dbportal;

CREATE TABLE flpgo122019 (
    si197_sequencial                  bigint DEFAULT 0 NOT NULL
      constraint flpgo122019_sequ_pk
      primary key,
    si197_tiporegistro                bigint,
    si197_indtipopagamento            varchar(1),
    si197_codvinculopessoa            varchar(15),
    si197_codrubricadesconto          varchar(4),
    si197_desctiporubricadesconto     varchar(150),
    si197_vlrdescontodetalhado        double precision,
    si197_reg10			      bigint default 0
      constraint flpgo122019_reg10_fk
      references flpgo102019,
    si197_mes                         bigint,
    si197_inst                        bigint
);

ALTER TABLE flpgo122019 OWNER TO dbportal;
CREATE SEQUENCE flpgo122019_si197_sequencial_seq;
ALTER SEQUENCE flpgo122019_si197_sequencial_seq OWNER TO dbportal;

CREATE TABLE respinf2019(
  si197_sequencial                    bigint default 0 not null
    constraint respinf2019_sequ_pk
    primary key,
  si197_nrodocumento                  varchar(11) not null,
  si197_dtinicio                      date,
  si197_dtfinal                       date,
  si197_mes                           bigint,
  si197_instit                        bigint
);

ALTER TABLE respinf2019 OWNER TO dbportal;
CREATE SEQUENCE respinf2019_si197_sequencial_seq;
ALTER SEQUENCE respinf2019_si197_sequencial_seq OWNER TO dbportal;

create table consid102019(
  si158_sequencial                    bigint default 0 not null
    constraint consid102019_sequ_pk
    primary key,
  si158_tiporegistro                  bigint default 0 not null,
  si158_codarquivo                    varchar(20)      not null,
  si158_exercicioreferenciaconsid     bigint default 0,
  si158_mesreferenciaconsid           varchar(2),
  si158_consideracoes                 varchar(4000)    not null,
  si158_mes                           bigint,
  si158_instit                        bigint
);

ALTER TABLE consid102019 owner to dbportal;
CREATE SEQUENCE consid102019_si158_sequencial_seq;
ALTER SEQUENCE consid102019_si158_sequencial_seq OWNER TO dbportal;

-- Fim do script

COMMIT;
*/
