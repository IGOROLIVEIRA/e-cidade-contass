/**
 * --------------------------------------------------------------------------------------------------------------------
 * TIME A INICIO
 * --------------------------------------------------------------------------------------------------------------------
 */

-- Tarefa 86645 / Geração RAIS
alter table cfpess add column r11_sistemacontroleponto int4 default null;

DROP TABLE IF EXISTS rhdirfparametros CASCADE;
DROP SEQUENCE IF EXISTS rhdirfparametros_rh132_sequencial_seq;

CREATE SEQUENCE rhdirfparametros_rh132_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE rhdirfparametros(
rh132_sequencial    int4 NOT NULL  default nextval('rhdirfparametros_rh132_sequencial_seq'),
rh132_anobase   int4 NOT NULL ,
rh132_valorminimo   float8 NOT NULL default 0,
rh132_codigoarquivo   varchar(10) ,
CONSTRAINT rhdirfparametros_sequ_pk PRIMARY KEY (rh132_sequencial));

insert into rhdirfparametros values (nextval('rhdirfparametros_rh132_sequencial_seq'), 2013, 25661.70, 'F8UCL6S');

/**
 * --------------------------------------------------------------------------------------------------------------------
 * TIME A FIM
 * --------------------------------------------------------------------------------------------------------------------
 */

/**
 * --------------------------------------------------------------------------------------------------------------------
 * TIME INTEGRACAO INICIO
 * --------------------------------------------------------------------------------------------------------------------
 */

select fc_executa_ddl('
CREATE TABLE transporteescolar.itinerariologradouro (
    tre10_sequencial integer DEFAULT 0 NOT NULL,
    tre10_linhatransporteitinerario integer DEFAULT 0 NOT NULL,
    tre10_cadenderbairrocadenderrua integer DEFAULT 0 NOT NULL,
    tre10_ordem integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.itinerariologradouro_tre10_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.linhatransporte (
    tre06_sequencial integer DEFAULT 0 NOT NULL,
    tre06_nome character varying(60) NOT NULL,
    tre06_abreviatura character varying(10)
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.linhatransporte_tre06_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.linhatransportehorario (
    tre07_sequencial integer DEFAULT 0 NOT NULL,
    tre07_linhatransporteitinerario integer DEFAULT 0 NOT NULL,
    tre07_horasaida character varying(5) NOT NULL,
    tre07_horachegada character varying(5)
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.linhatransportehorario_tre07_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.linhatransportehorarioveiculo (
    tre08_sequencial integer DEFAULT 0 NOT NULL,
    tre08_linhatransportehorario integer DEFAULT 0 NOT NULL,
    tre08_veiculotransportemunicipal integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.linhatransportehorarioveiculo_tre08_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.linhatransporteitinerario (
    tre09_sequencial integer DEFAULT 0 NOT NULL,
    tre09_linhatransporte integer DEFAULT 0 NOT NULL,
    tre09_tipo integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.linhatransporteitinerario_tre09_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.linhatransportepontoparada (
    tre11_sequencial integer DEFAULT 0 NOT NULL,
    tre11_pontoparada integer DEFAULT 0 NOT NULL,
    tre11_itinerariologradouro integer DEFAULT 0 NOT NULL,
    tre11_ordem integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.linhatransportepontoparada_tre11_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.linhatransportepontoparadaaluno (
    tre12_sequencial integer DEFAULT 0 NOT NULL,
    tre12_linhatransportepontoparada integer DEFAULT 0 NOT NULL,
    tre12_aluno bigint DEFAULT 0 NOT NULL,
    tre12_observacao text
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.linhatransportepontoparadaaluno_tre12_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.pontoparada (
    tre04_sequencial integer DEFAULT 0 NOT NULL,
    tre04_cadenderbairrocadenderrua integer DEFAULT 0 NOT NULL,
    tre04_nome character varying(70) NOT NULL,
    tre04_abreviatura character varying(10) NOT NULL,
    tre04_pontoreferencia text,
    tre04_latitude numeric(23,20),
    tre04_longitude numeric(23,20),
    tre04_tipo integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.pontoparada_tre04_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.pontoparadadepartamento (
    tre05_sequencial integer DEFAULT 0 NOT NULL,
    tre05_pontoparada integer DEFAULT 0 NOT NULL,
    tre05_db_depart integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.pontoparadadepartamento_tre05_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.veiculotransportemunicipal (
    tre01_sequencial integer DEFAULT 0 NOT NULL,
    tre01_tipotransportemunicipal integer DEFAULT 0 NOT NULL,
    tre01_identificacao character varying(25) NOT NULL,
    tre01_numeropassageiros integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.veiculotransportemunicipal_tre01_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.veiculotransportemunicipalterceiro (
    tre03_sequencial integer DEFAULT 0 NOT NULL,
    tre03_cgm integer DEFAULT 0 NOT NULL,
    tre03_veiculotransportemunicipal integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.veiculotransportemunicipalterceiro_tre03_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE transporteescolar.veiculotransportemunicipalveiculos (
    tre02_sequencial integer DEFAULT 0 NOT NULL,
    tre02_veiculos integer DEFAULT 0 NOT NULL,
    tre02_veiculotransportemunicipal integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.veiculotransportemunicipalveiculos_tre02_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.itinerariologradouro
    ADD CONSTRAINT itinerariologradouro_sequ_pk PRIMARY KEY (tre10_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransporte
    ADD CONSTRAINT linhatransporte_sequ_pk PRIMARY KEY (tre06_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportehorario
    ADD CONSTRAINT linhatransportehorario_sequ_pk PRIMARY KEY (tre07_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportehorarioveiculo
    ADD CONSTRAINT linhatransportehorarioveiculo_sequ_pk PRIMARY KEY (tre08_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransporteitinerario
    ADD CONSTRAINT linhatransporteitinerario_sequ_pk PRIMARY KEY (tre09_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportepontoparada
    ADD CONSTRAINT linhatransportepontoparada_sequ_pk PRIMARY KEY (tre11_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportepontoparadaaluno
    ADD CONSTRAINT linhatransportepontoparadaaluno_sequ_pk PRIMARY KEY (tre12_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.pontoparada
    ADD CONSTRAINT pontoparada_sequ_pk PRIMARY KEY (tre04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.pontoparadadepartamento
    ADD CONSTRAINT pontoparadadepartamento_sequ_pk PRIMARY KEY (tre05_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipal
    ADD CONSTRAINT veiculotransportemunicipal_sequ_pk PRIMARY KEY (tre01_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipalterceiro
    ADD CONSTRAINT veiculotransportemunicipalterceiro_sequ_pk PRIMARY KEY (tre03_sequencial);
');


select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipalveiculos
    ADD CONSTRAINT veiculotransportemunicipalveiculos_sequ_pk PRIMARY KEY (tre02_sequencial);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX itinerariologradouro_linhatransporteitinerario_cadenderbairroca ON transporteescolar.itinerariologradouro USING btree (tre10_linhatransporteitinerario, tre10_cadenderbairrocadenderrua);
');

select fc_executa_ddl('
CREATE INDEX linhatransportehorario_linhatransporteitinerario_in ON transporteescolar.linhatransportehorario USING btree (tre07_linhatransporteitinerario);
');

select fc_executa_ddl('
CREATE INDEX linhatransportehorarioveiculo_linhatransportehorario_in ON transporteescolar.linhatransportehorarioveiculo USING btree (tre08_linhatransportehorario);
');

select fc_executa_ddl('
CREATE INDEX linhatransportehorarioveiculo_veiculotransportemunicipal_in ON transporteescolar.linhatransportehorarioveiculo USING btree (tre08_veiculotransportemunicipal);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX linhatransporteitinerario_linhatransporte_tipo_in ON transporteescolar.linhatransporteitinerario USING btree (tre09_linhatransporte, tre09_tipo);
');

select fc_executa_ddl('
CREATE INDEX linhatransportepontoparada_itinerariologradouro_in ON transporteescolar.linhatransportepontoparada USING btree (tre11_itinerariologradouro);
');

select fc_executa_ddl('
CREATE INDEX linhatransportepontoparada_pontoparada_in ON transporteescolar.linhatransportepontoparada USING btree (tre11_pontoparada);
');

select fc_executa_ddl('
CREATE INDEX linhatransportepontoparadaaluno_aluno_in ON transporteescolar.linhatransportepontoparadaaluno USING btree (tre12_aluno);
');

select fc_executa_ddl('
CREATE INDEX linhatransportepontoparadaaluno_linhatransportepontoparada_in ON transporteescolar.linhatransportepontoparadaaluno USING btree (tre12_linhatransportepontoparada);
');

select fc_executa_ddl('
CREATE INDEX pontoparada_cadenderbairrocadenderrua_in ON transporteescolar.pontoparada USING btree (tre04_cadenderbairrocadenderrua);
');

select fc_executa_ddl('
CREATE INDEX pontoparadadepartamento_db_depart_in ON transporteescolar.pontoparadadepartamento USING btree (tre05_db_depart);
');

select fc_executa_ddl('
CREATE INDEX pontoparadadepartamento_pontoparada_in ON transporteescolar.pontoparadadepartamento USING btree (tre05_pontoparada);
');

select fc_executa_ddl('
CREATE INDEX veiculotransportemunicipal_tipotransportemunicipal_in ON transporteescolar.veiculotransportemunicipal USING btree (tre01_tipotransportemunicipal);
');

select fc_executa_ddl('
CREATE INDEX veiculotransportemunicipalterceiro_cgm_in ON transporteescolar.veiculotransportemunicipalterceiro USING btree (tre03_cgm);
');

select fc_executa_ddl('
CREATE INDEX veiculotransportemunicipalterceiro_veiculotransportemunicipal_i ON transporteescolar.veiculotransportemunicipalterceiro USING btree (tre03_veiculotransportemunicipal);
');

select fc_executa_ddl('
CREATE INDEX veiculotransportemunicipalveiculos_veiculos_in ON transporteescolar.veiculotransportemunicipalveiculos USING btree (tre02_veiculos);
');

select fc_executa_ddl('
CREATE INDEX veiculotransportemunicipalveiculos_veiculotransportemunicipal_i ON transporteescolar.veiculotransportemunicipalveiculos USING btree (tre02_veiculotransportemunicipal);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.itinerariologradouro
    ADD CONSTRAINT itinerariologradouro_cadenderbairrocadenderrua_fk FOREIGN KEY (tre10_cadenderbairrocadenderrua) REFERENCES configuracoes.cadenderbairrocadenderrua(db87_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.itinerariologradouro
    ADD CONSTRAINT itinerariologradouro_linhatransporteitinerario_fk FOREIGN KEY (tre10_linhatransporteitinerario) REFERENCES transporteescolar.linhatransporteitinerario(tre09_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportehorario
    ADD CONSTRAINT linhatransportehorario_linhatransporteitinerario_fk FOREIGN KEY (tre07_linhatransporteitinerario) REFERENCES transporteescolar.linhatransporteitinerario(tre09_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportehorarioveiculo
    ADD CONSTRAINT linhatransportehorarioveiculo_linhatransportehorario_fk FOREIGN KEY (tre08_linhatransportehorario) REFERENCES transporteescolar.linhatransportehorario(tre07_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportehorarioveiculo
    ADD CONSTRAINT linhatransportehorarioveiculo_veiculotransportemunicipal_fk FOREIGN KEY (tre08_veiculotransportemunicipal) REFERENCES transporteescolar.veiculotransportemunicipal(tre01_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransporteitinerario
    ADD CONSTRAINT linhatransporteitinerario_linhatransporte_fk FOREIGN KEY (tre09_linhatransporte) REFERENCES transporteescolar.linhatransporte(tre06_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportepontoparada
    ADD CONSTRAINT linhatransportepontoparada_itinerariologradouro_fk FOREIGN KEY (tre11_itinerariologradouro) REFERENCES transporteescolar.itinerariologradouro(tre10_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportepontoparada
    ADD CONSTRAINT linhatransportepontoparada_pontoparada_fk FOREIGN KEY (tre11_pontoparada) REFERENCES transporteescolar.pontoparada(tre04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportepontoparadaaluno
    ADD CONSTRAINT linhatransportepontoparadaaluno_aluno_fk FOREIGN KEY (tre12_aluno) REFERENCES escola.aluno(ed47_i_codigo);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.linhatransportepontoparadaaluno
    ADD CONSTRAINT linhatransportepontoparadaaluno_linhatransportepontoparada_fk FOREIGN KEY (tre12_linhatransportepontoparada) REFERENCES transporteescolar.linhatransportepontoparada(tre11_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.pontoparada
    ADD CONSTRAINT pontoparada_cadenderbairrocadenderrua_fk FOREIGN KEY (tre04_cadenderbairrocadenderrua) REFERENCES configuracoes.cadenderbairrocadenderrua(db87_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.pontoparadadepartamento
    ADD CONSTRAINT pontoparadadepartamento_depart_fk FOREIGN KEY (tre05_db_depart) REFERENCES configuracoes.db_depart(coddepto);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.pontoparadadepartamento
    ADD CONSTRAINT pontoparadadepartamento_pontoparada_fk FOREIGN KEY (tre05_pontoparada) REFERENCES transporteescolar.pontoparada(tre04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipal
    ADD CONSTRAINT veiculotransportemunicipal_tipotransportemunicipal_fk FOREIGN KEY (tre01_tipotransportemunicipal) REFERENCES transporteescolar.tipotransportemunicipal(tre00_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipalterceiro
    ADD CONSTRAINT veiculotransportemunicipalterceiro_cgm_fk FOREIGN KEY (tre03_cgm) REFERENCES protocolo.cgm(z01_numcgm);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipalterceiro
    ADD CONSTRAINT veiculotransportemunicipalterceiro_veiculotransportemunicipal_f FOREIGN KEY (tre03_veiculotransportemunicipal) REFERENCES transporteescolar.veiculotransportemunicipal(tre01_sequencial);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipalveiculos
    ADD CONSTRAINT veiculotransportemunicipalveiculos_veiculos_fk FOREIGN KEY (tre02_veiculos) REFERENCES veiculos.veiculos(ve01_codigo);
');

select fc_executa_ddl('
ALTER TABLE transporteescolar.veiculotransportemunicipalveiculos
    ADD CONSTRAINT veiculotransportemunicipalveiculos_veiculotransportemunicipal_f FOREIGN KEY (tre02_veiculotransportemunicipal) REFERENCES transporteescolar.veiculotransportemunicipal(tre01_sequencial);
');


select fc_executa_ddl('
CREATE TABLE social.cadastrounicobasemunicipal (
    as09_sequencial integer DEFAULT 0 NOT NULL,
    as09_tiporegistro integer DEFAULT 0 NOT NULL,
    as09_chaveregistro character varying(100) NOT NULL,
    as09_conteudolinha text NOT NULL
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cadastrounicobasemunicipal_as09_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cadastrounicosituacao (
    as12_sequencial integer DEFAULT 0 NOT NULL,
    as12_cidadaocadastrounico integer DEFAULT 0 NOT NULL,
    as12_tiposituacaocadastrounico integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cadastrounicosituacao_as12_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaoavaliacao (
    as01_sequencial integer DEFAULT 0 NOT NULL,
    as01_cidadao integer DEFAULT 0 NOT NULL,
    as01_cidadao_seq integer DEFAULT 0 NOT NULL,
    as01_avaliacaogruporesposta integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaoavaliacao_as01_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaobeneficio (
    as08_sequencial integer DEFAULT 0 NOT NULL,
    as08_programasocial integer DEFAULT 0 NOT NULL,
    as08_mes integer DEFAULT 0 NOT NULL,
    as08_ano integer DEFAULT 0 NOT NULL,
    as08_situacao character varying(50) NOT NULL,
    as08_nis character varying(20) NOT NULL,
    as08_tipobeneficio character varying(50) NOT NULL,
    as08_datasituacao date,
    as08_dataconcessao date,
    as08_motivo text NOT NULL,
    as08_justificativa text
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaobeneficio_as08_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaocadastrounico (
    as02_sequencial integer DEFAULT 0 NOT NULL,
    as02_cidadao integer DEFAULT 0 NOT NULL,
    as02_cidadao_seq integer DEFAULT 0 NOT NULL,
    as02_nis character varying(20) DEFAULT \'0\'::character varying NOT NULL,
    as02_apelido character varying(50),
    as02_dataatualizacao date,
    as02_codigounicocidadao character varying(20)
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaocadastrounico_as02_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaocomposicaofamiliar (
    as03_sequencial integer DEFAULT 0 NOT NULL,
    as03_cidadao integer DEFAULT 0 NOT NULL,
    as03_cidadao_seq integer DEFAULT 0 NOT NULL,
    as03_tipofamiliar integer DEFAULT 0 NOT NULL,
    as03_cidadaofamilia integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaocomposicaofamiliar_as03_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaofamilia (
    as04_sequencial integer DEFAULT 0 NOT NULL,
    as04_dataentrevista date NOT NULL,
    as04_rendafamiliar numeric DEFAULT 0 NOT NULL,
    as04_dataatualizacao date,
    as04_aparelhoeletricocontinuo boolean DEFAULT false
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaofamilia_as04_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');
select fc_executa_ddl('
CREATE TABLE social.cidadaofamiliaavaliacao (
    as06_sequencial integer DEFAULT 0 NOT NULL,
    as06_cidadaofamilia integer DEFAULT 0 NOT NULL,
    as06_avaliacaogruporesposta integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaofamiliaavaliacao_as06_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaofamiliacadastrounico (
    as15_sequencial integer DEFAULT 0 NOT NULL,
    as15_cidadaofamilia integer DEFAULT 0 NOT NULL,
    as15_codigofamiliarcadastrounico character varying(20) DEFAULT \'0\'::character varying
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaofamiliacadastrounico_as15_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaofamiliavisita (
    as05_sequencial integer DEFAULT 0 NOT NULL,
    as05_cidadaofamilia integer DEFAULT 0 NOT NULL,
    as05_datavisita date NOT NULL,
    as05_observacao text,
    as05_profissional integer,
    as05_horavisita character(5) DEFAULT NULL::bpchar,
    as05_visitatipo integer
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaofamiliavisita_as05_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaofamiliavisitacontato (
    as10_sequencial integer DEFAULT 0 NOT NULL,
    as10_cidadaofamiliavisita integer DEFAULT 0 NOT NULL,
    as10_profissionalcontato integer DEFAULT 0 NOT NULL,
    as10_data date
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaofamiliavisitacontato_as10_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cidadaofamiliavisitaencaminhamento (
    as14_sequencial integer DEFAULT 0 NOT NULL,
    as14_cidadaofamiliavisita integer DEFAULT 0 NOT NULL,
    as14_cgm integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cidadaofamiliavisitaencaminhamento_as14_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE SEQUENCE social.cursocialcidadao_as22_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cursosocial (
    as19_sequencial integer DEFAULT 0 NOT NULL,
    as19_nome character varying(70) NOT NULL,
    as19_detalhamento text NOT NULL,
    as19_tabcurritipo integer DEFAULT 0 NOT NULL,
    as19_inicio date NOT NULL,
    as19_fim date NOT NULL,
    as19_horaaulasdia numeric(10,0) NOT NULL,
    as19_ministrante integer DEFAULT 0 NOT NULL,
    as19_responsavel integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cursosocial_as19_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cursosocialaula (
    as21_sequencial integer DEFAULT 0 NOT NULL,
    as21_cursosocial integer DEFAULT 0 NOT NULL,
    as21_dataaula date
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cursosocialaula_as21_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cursosocialcidadao (
    as22_sequencial integer DEFAULT 0 NOT NULL,
    as22_cursosocial integer DEFAULT 0 NOT NULL,
    as22_cidadao integer DEFAULT 0 NOT NULL,
    as22_cidadao_seq integer DEFAULT 0 NOT NULL,
    as22_observacao text
);
');

select fc_executa_ddl('
CREATE TABLE social.cursosocialcidadaoausencia (
    as18_sequencial integer DEFAULT 0 NOT NULL,
    as18_cursosocialaula integer DEFAULT 0 NOT NULL,
    as18_cursocialcidadao integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cursosocialcidadaoausencia_as18_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.cursosocialdiasemana (
    as20_sequencial integer DEFAULT 0 NOT NULL,
    as20_cursosocial integer DEFAULT 0 NOT NULL,
    as20_diasemana integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.cursosocialdiasemana_as20_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.importacaocadastrounico (
    as07_sequencial integer DEFAULT 0 NOT NULL,
    as07_usuario integer DEFAULT 0 NOT NULL,
    as07_dataarquivo date NOT NULL,
    as07_dataprocessamento date NOT NULL,
    as07_hora character(5)
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.importacaocadastrounico_as07_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE SEQUENCE social.localatendimentocidadao_as17_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
CREATE TABLE social.localatendimentofamilia (
    as23_sequencial integer DEFAULT 0 NOT NULL,
    as23_localatendimentosocial integer DEFAULT 0 NOT NULL,
    as23_cidadaofamilia integer DEFAULT 0 NOT NULL,
    as23_datavinculo date NOT NULL,
    as23_fimatendimento date,
    as23_observacao text,
    as23_ativo boolean DEFAULT false,
    as23_db_usuario integer DEFAULT 0
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.localatendimentofamilia_as23_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('CREATE TABLE social.localatendimentosocial (
    as16_sequencial integer DEFAULT 0 NOT NULL,
    as16_tipo integer DEFAULT 0 NOT NULL,
    as16_descricao character varying(70) DEFAULT \'null\'::character varying,
    as16_identificadorunico character varying(20),
    as16_db_depart integer DEFAULT 0
);
');

select fc_executa_ddl('CREATE SEQUENCE social.localatendimentosocial_as16_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');


select fc_executa_ddl('
CREATE TABLE social.visitatipo (
    as13_sequencial integer DEFAULT 0 NOT NULL,
    as13_descricao character varying(80) NOT NULL,
    as13_exigeencaminhamento boolean DEFAULT false
);
');

select fc_executa_ddl('
CREATE SEQUENCE social.visitatipo_as13_sequencial_seq
    START WITH 2
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');

select fc_executa_ddl('
insert into social.visitatipo values(1, \'Visita Normal\', \'f\');
');

select fc_executa_ddl('
ALTER TABLE social.cadastrounicobasemunicipal ADD CONSTRAINT cadastrounicobasemunicipal_sequ_pk PRIMARY KEY (as09_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cadastrounicosituacao ADD CONSTRAINT cadastrounicosituacao_sequ_pk PRIMARY KEY (as12_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaoavaliacao ADD CONSTRAINT cidadaoavaliacao_sequ_pk PRIMARY KEY (as01_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaobeneficio ADD CONSTRAINT cidadaobeneficio_sequ_pk PRIMARY KEY (as08_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaocadastrounico ADD CONSTRAINT cidadaocadastrounico_sequ_pk PRIMARY KEY (as02_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaocomposicaofamiliar ADD CONSTRAINT cidadaocomposicaofamiliar_sequ_pk PRIMARY KEY (as03_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamilia ADD CONSTRAINT cidadaofamilia_sequ_pk PRIMARY KEY (as04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliaavaliacao ADD CONSTRAINT cidadaofamiliaavaliacao_sequ_pk PRIMARY KEY (as06_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliacadastrounico ADD CONSTRAINT cidadaofamiliacadastrounico_sequ_pk PRIMARY KEY (as15_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisita ADD CONSTRAINT cidadaofamiliavisita_sequ_pk PRIMARY KEY (as05_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisitacontato ADD CONSTRAINT cidadaofamiliavisitacontato_sequ_pk PRIMARY KEY (as10_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisitaencaminhamento ADD CONSTRAINT cidadaofamiliavisitaencaminhamento_sequ_pk PRIMARY KEY (as14_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocial ADD CONSTRAINT cursosocial_sequ_pk PRIMARY KEY (as19_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialaula ADD CONSTRAINT cursosocialaula_sequ_pk PRIMARY KEY (as21_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialcidadao ADD CONSTRAINT cursosocialcidadao_sequ_pk PRIMARY KEY (as22_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialcidadaoausencia ADD CONSTRAINT cursosocialcidadaoausencia_sequ_pk PRIMARY KEY (as18_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialdiasemana ADD CONSTRAINT cursosocialdiasemana_sequ_pk PRIMARY KEY (as20_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.importacaocadastrounico ADD CONSTRAINT importacaocadastrounico_sequ_pk PRIMARY KEY (as07_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.localatendimentofamilia ADD CONSTRAINT localatendimentofamilia_sequ_pk PRIMARY KEY (as23_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.localatendimentosocial ADD CONSTRAINT localatendimentosocial_sequ_pk PRIMARY KEY (as16_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.visitatipo ADD CONSTRAINT visitatipo_sequ_pk PRIMARY KEY (as13_sequencial);
');

select fc_executa_ddl('
CREATE INDEX cadastrounicobasemunicipal_chaveregistro_in ON social.cadastrounicobasemunicipal USING btree (as09_chaveregistro);
');

select fc_executa_ddl('
CREATE INDEX cadastrounicobasemunicipal_tiporegistro_in ON social.cadastrounicobasemunicipal USING btree (as09_tiporegistro);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cadastrounicosituacao_cidadaocadastrounico_tiposituacaocadastro ON social.cadastrounicosituacao USING btree (as12_cidadaocadastrounico, as12_tiposituacaocadastrounico);
');

select fc_executa_ddl('
CREATE INDEX cidadaoavaliacao_avaliacaogruporesposta_in ON social.cidadaoavaliacao USING btree (as01_avaliacaogruporesposta);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cidadaoavaliacao_cidadao_avaliacaogruporesposta_in ON social.cidadaoavaliacao USING btree (as01_cidadao, as01_avaliacaogruporesposta);
');

select fc_executa_ddl('
CREATE INDEX cidadaoavaliacao_cidadao_cidadao_seq_in ON social.cidadaoavaliacao USING btree (as01_cidadao, as01_cidadao_seq);
');

select fc_executa_ddl('
CREATE INDEX cidadaobeneficio_ano_in ON social.cidadaobeneficio USING btree (as08_ano);
');

select fc_executa_ddl('
CREATE INDEX cidadaobeneficio_mes_in ON social.cidadaobeneficio USING btree (as08_mes);
');

select fc_executa_ddl('
CREATE INDEX cidadaobeneficio_nis_in ON social.cidadaobeneficio USING btree (as08_nis);
');

select fc_executa_ddl('
CREATE INDEX cidadaobeneficio_tipobeneficio_in ON social.cidadaobeneficio USING btree (as08_tipobeneficio);
');

select fc_executa_ddl('
CREATE INDEX cidadaocadastrounico_cidadao_cidadao_seq_in ON social.cidadaocadastrounico USING btree (as02_cidadao, as02_cidadao_seq);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cidadaocadastrounico_codigounicocidadao_in ON social.cidadaocadastrounico USING btree (as02_codigounicocidadao);
');

select fc_executa_ddl('
CREATE INDEX cidadaocomposicaofamiliar_cidadao_cidadao_seq_in ON social.cidadaocomposicaofamiliar USING btree (as03_cidadao, as03_cidadao_seq);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cidadaocomposicaofamiliar_cidadao_cidadaofamilia_in ON social.cidadaocomposicaofamiliar USING btree (as03_cidadao, as03_cidadaofamilia);
');

select fc_executa_ddl('
CREATE INDEX cidadaocomposicaofamiliar_cidadaofamilia_in ON social.cidadaocomposicaofamiliar USING btree (as03_cidadaofamilia);
');

select fc_executa_ddl('
CREATE INDEX cidadaocomposicaofamiliar_tipofamiliar_in ON social.cidadaocomposicaofamiliar USING btree (as03_tipofamiliar);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliaavaliacao_avaliacaogruporesposta_in ON social.cidadaofamiliaavaliacao USING btree (as06_avaliacaogruporesposta);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cidadaofamiliaavaliacao_cidadaofamilia_avaliacaogruporesposta_i ON social.cidadaofamiliaavaliacao USING btree (as06_cidadaofamilia, as06_avaliacaogruporesposta);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliaavaliacao_cidadaofamilia_in ON social.cidadaofamiliaavaliacao USING btree (as06_cidadaofamilia);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cidadaofamiliacadastrounico_cidadaofamilia_codigofamiliarcadast ON social.cidadaofamiliacadastrounico USING btree (as15_cidadaofamilia, as15_codigofamiliarcadastrounico);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisita_cidadaofamilia_in ON social.cidadaofamiliavisita USING btree (as05_cidadaofamilia);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisita_profissional_in ON social.cidadaofamiliavisita USING btree (as05_profissional);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisita_visitatipo_in ON social.cidadaofamiliavisita USING btree (as05_visitatipo);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisitacontato_cidadaofamiliavisita_in ON social.cidadaofamiliavisitacontato USING btree (as10_cidadaofamiliavisita);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisitacontato_profissionalcontato_in ON social.cidadaofamiliavisitacontato USING btree (as10_profissionalcontato);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisitaencaminhamento_cgm_in ON social.cidadaofamiliavisitaencaminhamento USING btree (as14_cgm);
');

select fc_executa_ddl('
CREATE INDEX cidadaofamiliavisitaencaminhamento_cidadaofamiliavisita_in ON social.cidadaofamiliavisitaencaminhamento USING btree (as14_cidadaofamiliavisita);
');

select fc_executa_ddl('
CREATE INDEX cursocialcidadao_cidadao_cidadaoseq_in ON social.cursosocialcidadao USING btree (as22_cidadao, as22_cidadao_seq);
');

select fc_executa_ddl('
CREATE INDEX cursocialcidadao_cursosocial_in ON social.cursosocialcidadao USING btree (as22_cursosocial);
');

select fc_executa_ddl('
CREATE INDEX cursosocial_ministrante_in ON social.cursosocial USING btree (as19_ministrante);
');

select fc_executa_ddl('
CREATE INDEX cursosocial_responsavel_in ON social.cursosocial USING btree (as19_responsavel);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cursosocialaula_cursosocial_dataaula_in ON social.cursosocialaula USING btree (as21_cursosocial, as21_dataaula);
');

select fc_executa_ddl('
CREATE INDEX cursosocialaula_cursosocial_in ON social.cursosocialaula USING btree (as21_cursosocial);
');

select fc_executa_ddl('
CREATE INDEX cursosocialcidadaoausencia_cursocialcidadao_in ON social.cursosocialcidadaoausencia USING btree (as18_cursocialcidadao);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cursosocialcidadaoausencia_cursosocialaula_cursocialcidadao_in ON social.cursosocialcidadaoausencia USING btree (as18_cursosocialaula, as18_cursocialcidadao);
');

select fc_executa_ddl('
CREATE INDEX cursosocialcidadaoausencia_cursosocialaula_in ON social.cursosocialcidadaoausencia USING btree (as18_cursosocialaula);
');

select fc_executa_ddl('
CREATE INDEX cursosocialdiasemana_cursosocial_in ON social.cursosocialdiasemana USING btree (as20_cursosocial);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX cursosocialdiasemana_diasemana_cursosocia_in ON social.cursosocialdiasemana USING btree (as20_diasemana, as20_cursosocial);
');

select fc_executa_ddl('
CREATE INDEX importacaocadastrounico_usuario_in ON social.importacaocadastrounico USING btree (as07_usuario);
');

select fc_executa_ddl('
CREATE INDEX localatendimentofamilia_cidadaofamilia_in ON social.localatendimentofamilia USING btree (as23_cidadaofamilia);
');

select fc_executa_ddl('
CREATE INDEX localatendimentofamilia_db_usuario_in ON social.localatendimentofamilia USING btree (as23_db_usuario);
');

select fc_executa_ddl('
CREATE INDEX localatendimentofamilia_localatendimentosocial_in ON social.localatendimentofamilia USING btree (as23_localatendimentosocial);
');

select fc_executa_ddl('
CREATE UNIQUE INDEX localatendimentosocial_db_depart_in ON social.localatendimentosocial USING btree (as16_db_depart);
');

select fc_executa_ddl('
ALTER TABLE social.cadastrounicosituacao 
  ADD CONSTRAINT cadastrounicosituacao_cidadaocadastrounico_fk FOREIGN KEY (as12_cidadaocadastrounico) REFERENCES social.cidadaocadastrounico(as02_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cadastrounicosituacao 
  ADD CONSTRAINT cadastrounicosituacao_tiposituacaocadastrounico_fk FOREIGN KEY (as12_tiposituacaocadastrounico) REFERENCES social.tiposituacaocadastrounico(as11_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisita 
  ADD CONSTRAINT cgm_cidadaofamiliavisita_fk FOREIGN KEY (as05_profissional) REFERENCES protocolo.cgm(z01_numcgm);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaoavaliacao 
  ADD CONSTRAINT cidadaoavaliacao_avaliacaogruporesposta_fk FOREIGN KEY (as01_avaliacaogruporesposta) REFERENCES habitacao.avaliacaogruporesposta(db107_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaoavaliacao 
  ADD CONSTRAINT cidadaoavaliacao_cidadao_seq_fk FOREIGN KEY (as01_cidadao, as01_cidadao_seq) REFERENCES ouvidoria.cidadao(ov02_sequencial, ov02_seq);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaocadastrounico 
  ADD CONSTRAINT cidadaocadastrounico_cidadao_seq_fk FOREIGN KEY (as02_cidadao, as02_cidadao_seq) REFERENCES ouvidoria.cidadao(ov02_sequencial, ov02_seq);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaocomposicaofamiliar 
  ADD CONSTRAINT cidadaocomposicaofamiliar_cidadao_seq_fk FOREIGN KEY (as03_cidadao, as03_cidadao_seq) REFERENCES ouvidoria.cidadao(ov02_sequencial, ov02_seq);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaocomposicaofamiliar 
ADD CONSTRAINT cidadaocomposicaofamiliar_cidadaofamilia_fk FOREIGN KEY (as03_cidadaofamilia) REFERENCES social.cidadaofamilia(as04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaocomposicaofamiliar
  ADD CONSTRAINT cidadaocomposicaofamiliar_tipofamiliar_fk FOREIGN KEY (as03_tipofamiliar) REFERENCES protocolo.tipofamiliar(z14_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliaavaliacao
    ADD CONSTRAINT cidadaofamiliaavaliacao_avaliacaogruporesposta_fk FOREIGN KEY (as06_avaliacaogruporesposta) REFERENCES habitacao.avaliacaogruporesposta(db107_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliaavaliacao
    ADD CONSTRAINT cidadaofamiliaavaliacao_cidadaofamilia_fk FOREIGN KEY (as06_cidadaofamilia) REFERENCES social.cidadaofamilia(as04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliacadastrounico
    ADD CONSTRAINT cidadaofamiliacadastrounico_cidadaofamilia_fk FOREIGN KEY (as15_cidadaofamilia) REFERENCES social.cidadaofamilia(as04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisita
    ADD CONSTRAINT cidadaofamiliavisita_cidadaofamilia_fk FOREIGN KEY (as05_cidadaofamilia) REFERENCES social.cidadaofamilia(as04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisita
    ADD CONSTRAINT cidadaofamiliavisita_visitatipo_fk FOREIGN KEY (as05_visitatipo) REFERENCES social.visitatipo(as13_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisitacontato
    ADD CONSTRAINT cidadaofamiliavisitacontato_cidadaofamiliavisita_fk FOREIGN KEY (as10_cidadaofamiliavisita) REFERENCES social.cidadaofamiliavisita(as05_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisitacontato
    ADD CONSTRAINT cidadaofamiliavisitacontato_profissionalcontato_fk FOREIGN KEY (as10_profissionalcontato) REFERENCES protocolo.cgm(z01_numcgm);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisitaencaminhamento
    ADD CONSTRAINT cidadaofamiliavisitaencaminhamento_cgm_fk FOREIGN KEY (as14_cgm) REFERENCES protocolo.cgm(z01_numcgm);
');

select fc_executa_ddl('
ALTER TABLE social.cidadaofamiliavisitaencaminhamento
    ADD CONSTRAINT cidadaofamiliavisitaencaminhamento_cidadaofamiliavisita_fk FOREIGN KEY (as14_cidadaofamiliavisita) REFERENCES social.cidadaofamiliavisita(as05_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocial
    ADD CONSTRAINT cursosocial_ministrante_fk FOREIGN KEY (as19_ministrante) REFERENCES protocolo.cgm(z01_numcgm);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocial
    ADD CONSTRAINT cursosocial_responsavel_fk FOREIGN KEY (as19_responsavel) REFERENCES protocolo.cgm(z01_numcgm);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocial
    ADD CONSTRAINT cursosocial_tabcurritipo_fk FOREIGN KEY (as19_tabcurritipo) REFERENCES recursoshumanos.tabcurritipo(h02_codigo);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialaula
    ADD CONSTRAINT cursosocialaula_cursosocial_fk FOREIGN KEY (as21_cursosocial) REFERENCES social.cursosocial(as19_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialcidadao
    ADD CONSTRAINT cursosocialcidadao_cidadao_seq_fk FOREIGN KEY (as22_cidadao, as22_cidadao_seq) REFERENCES ouvidoria.cidadao(ov02_sequencial, ov02_seq);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialcidadao
    ADD CONSTRAINT cursosocialcidadao_cursosocial_fk FOREIGN KEY (as22_cursosocial) REFERENCES social.cursosocial(as19_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialcidadaoausencia
    ADD CONSTRAINT cursosocialcidadaoausencia_cursocialcidadao_fk FOREIGN KEY (as18_cursocialcidadao) REFERENCES social.cursosocialcidadao(as22_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialcidadaoausencia
    ADD CONSTRAINT cursosocialcidadaoausencia_cursosocialaula_fk FOREIGN KEY (as18_cursosocialaula) REFERENCES social.cursosocialaula(as21_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialdiasemana
    ADD CONSTRAINT cursosocialdiasemana_cursosocial_fk FOREIGN KEY (as20_cursosocial) REFERENCES social.cursosocial(as19_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.cursosocialdiasemana
    ADD CONSTRAINT cursosocialdiasemana_diasemana_fk FOREIGN KEY (as20_diasemana) REFERENCES escola.diasemana(ed32_i_codigo);
');

select fc_executa_ddl('
ALTER TABLE social.importacaocadastrounico
    ADD CONSTRAINT importacaocadastrounico_usuario_fk FOREIGN KEY (as07_usuario) REFERENCES configuracoes.db_usuarios(id_usuario);
');

select fc_executa_ddl('
ALTER TABLE social.localatendimentofamilia
    ADD CONSTRAINT localatendimentofamilia_cidadaofamilia_fk FOREIGN KEY (as23_cidadaofamilia) REFERENCES social.cidadaofamilia(as04_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.localatendimentofamilia
    ADD CONSTRAINT localatendimentofamilia_localatendimentosocial_fk FOREIGN KEY (as23_localatendimentosocial) REFERENCES social.localatendimentosocial(as16_sequencial);
');

select fc_executa_ddl('
ALTER TABLE social.localatendimentofamilia
    ADD CONSTRAINT localatendimentofamilia_usuario_fk FOREIGN KEY (as23_db_usuario) REFERENCES configuracoes.db_usuarios(id_usuario);
');

select fc_executa_ddl('
ALTER TABLE social.localatendimentosocial
    ADD CONSTRAINT localatendimentosocial_depart_fk FOREIGN KEY (as16_db_depart) REFERENCES configuracoes.db_depart(coddepto);
');
/**
 * --------------------------------------------------------------------------------------------------------------------
 * TIME INTEGRACAO FIM
 * --------------------------------------------------------------------------------------------------------------------
 */
