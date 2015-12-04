--DROP TABLE:
--DROP TABLE sau_atendprest CASCADE;
--DROP TABLE sau_atividadeensino CASCADE;
--DROP TABLE sau_convenio CASCADE;
--DROP TABLE sau_esferaadmin CASCADE;
--DROP TABLE sau_fluxocliente CASCADE;
--DROP TABLE sau_gestaoativ CASCADE;
--DROP TABLE sau_modvinculo CASCADE;
--DROP TABLE sau_natorg CASCADE;
--DROP TABLE sau_nivelhier CASCADE;
--DROP TABLE sau_orgaoemissor CASCADE;
--DROP TABLE sau_retentributo CASCADE;
--DROP TABLE sau_subtpmodvinculo CASCADE;
--DROP TABLE sau_tipoatend CASCADE;
--DROP TABLE sau_tipounidade CASCADE;
--DROP TABLE sau_tpmodvinculo CASCADE;
--DROP TABLE sau_turnoatend CASCADE;
--DROP TABLE sau_vinculosus CASCADE;
--Criando drop sequences
--DROP SEQUENCE sau_gestaoativ_sd47_i_codigo_seq;
--DROP SEQUENCE sau_vinculosus_sd50_i_codigo_seq;


-- Criando  sequences
CREATE SEQUENCE sau_gestaoativ_sd47_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_vinculosus_sd50_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: saude
CREATE TABLE sau_atendprest(
sd46_i_codigio          int4 default 0,
sd46_v_descricao          varchar(60) ,
CONSTRAINT sau_atendprest_codi_pk PRIMARY KEY (sd46_i_codigio));


-- Módulo: saude
CREATE TABLE sau_atividadeensino(
sd38_i_cod_ativid          int4 default 0,
sd38_v_descricao          varchar(60) ,
CONSTRAINT sau_atividadeensino_cod_pk PRIMARY KEY (sd38_i_cod_ativid));


-- Módulo: saude
CREATE TABLE sau_convenio(
sd49_i_codigo          int4 default 0,
sd49_v_descricao          varchar(60) ,
CONSTRAINT sau_convenio_codi_pk PRIMARY KEY (sd49_i_codigo));


-- Módulo: saude
CREATE TABLE sau_esferaadmin(
sd37_i_cod_esfadm          int4 default 0,
sd37_v_descricao          varchar(60) ,
CONSTRAINT sau_esferaadmin_cod_pk PRIMARY KEY (sd37_i_cod_esfadm));


-- Módulo: saude
CREATE TABLE sau_fluxocliente(
sd41_i_cod_cliente          int4 default 0,
sd41_v_descricao          varchar(60) ,
CONSTRAINT sau_fluxocliente_cod_pk PRIMARY KEY (sd41_i_cod_cliente));


-- Módulo: saude
CREATE TABLE sau_gestaoativ(
sd47_i_codigo          int4 default 0,
sd47_i_unidade          int4 default 0,
sd47_i_programa          int4 default 0,
sd47_i_indgestao          int4 default 0,
CONSTRAINT sau_gestaoativ_codi_pk PRIMARY KEY (sd47_i_codigo));


-- Módulo: saude
CREATE TABLE sau_modvinculo(
sd52_i_vinculacao          int4 default 0,
sd52_v_descricao          varchar(60) ,
CONSTRAINT sau_modvinculo_vinc_pk PRIMARY KEY (sd52_i_vinculacao));


-- Módulo: saude
CREATE TABLE sau_natorg(
sd40_i_cod_natorg          int4 default 0,
sd40_v_descricao          varchar(60) ,
CONSTRAINT sau_natorg_cod_pk PRIMARY KEY (sd40_i_cod_natorg));


-- Módulo: saude
CREATE TABLE sau_nivelhier(
sd44_i_codnivhier          int4 default 0,
sd44_v_descricao          varchar(60) ,
CONSTRAINT sau_nivelhier_codn_pk PRIMARY KEY (sd44_i_codnivhier));


-- Módulo: saude
CREATE TABLE sau_orgaoemissor(
sd51_i_codigo          int4 default 0,
sd51_v_descricao          varchar(60) ,
CONSTRAINT sau_orgaoemissor_codi_pk PRIMARY KEY (sd51_i_codigo));


-- Módulo: saude
CREATE TABLE sau_retentributo(
sd39_i_cod_reten          int4 default 0,
sd39_v_situacao          varchar(60) ,
CONSTRAINT sau_retentributo_cod_pk PRIMARY KEY (sd39_i_cod_reten));


-- Módulo: saude
CREATE TABLE sau_subtpmodvinculo(
sd54_i_vinculacao          int4 default 0,
sd54_i_tpvinculo          int4 default 0,
sd54_i_tpsubvinculo          int4 default 0,
sd54_v_descricao          varchar(60) ,
CONSTRAINT sau_subtpmodvinculo_vinc_tpvi_tpsu_pk PRIMARY KEY (sd54_i_vinculacao,sd54_i_tpvinculo,sd54_i_tpsubvinculo));


-- Módulo: saude
CREATE TABLE sau_tipoatend(
sd45_i_codigo          int4 default 0,
sd45_v_descricao          varchar(60) ,
sd45_i_programa          int4 default 0,
CONSTRAINT sau_tipoatend_codi_pk PRIMARY KEY (sd45_i_codigo));


-- Módulo: saude
CREATE TABLE sau_tipounidade(
sd42_i_tp_unid_id          int4 default 0,
sd42_v_descricao          varchar(60) ,
CONSTRAINT sau_tipounidade_tp_pk PRIMARY KEY (sd42_i_tp_unid_id));


-- Módulo: saude
CREATE TABLE sau_tpmodvinculo(
sd53_i_vinculacao          int4 default 0,
sd53_i_tpvinculo          int4 default 0,
sd53_v_descrvinculo          varchar(60) ,
sd53_i_tpesfadm          int4 default 0,
CONSTRAINT sau_tpmodvinculo_tpvi_vinc_pk PRIMARY KEY (sd53_i_tpvinculo,sd53_i_vinculacao));


-- Módulo: saude
CREATE TABLE sau_turnoatend(
sd43_cod_turnat          int4 default 0,
sd43_v_descricao          varchar(100) ,
CONSTRAINT sau_turnoatend_turn_pk PRIMARY KEY (sd43_cod_turnat));


-- Módulo: saude
CREATE TABLE sau_vinculosus(
sd50_i_codigo          int4 default 0,
sd50_i_unidade          int4 default 0,
sd50_v_banco          varchar(3) ,
sd50_v_agencia          varchar(5) ,
sd50_v_cc          varchar(14) ,
sd50_v_contratosus          varchar(60) ,
sd50_d_publicacao          date default null,
sd50_v_contratosus2          varchar(60) ,
sd50_d_publicacao2          date default null,
CONSTRAINT sau_vinculosus_codi_pk PRIMARY KEY (sd50_i_codigo));




-- CHAVE ESTRANGEIRA


ALTER TABLE sau_gestaoativ
ADD CONSTRAINT sau_gestaoativ_i_unidade_fk FOREIGN KEY (sd47_i_unidade)
REFERENCES unidades;

ALTER TABLE sau_gestaoativ
ADD CONSTRAINT sau_gestaoativ_i_programa_fk FOREIGN KEY (sd47_i_programa)
REFERENCES sau_tipoatend;

ALTER TABLE sau_tpmodvinculo
ADD CONSTRAINT sau_tpmodvinculo_i_tpesfadm_fk FOREIGN KEY (sd53_i_tpesfadm)
REFERENCES sau_esferaadmin;

ALTER TABLE sau_vinculosus
ADD CONSTRAINT sau_vinculosus_i_unidade_fk FOREIGN KEY (sd50_i_unidade)
REFERENCES unidades;




-- INDICES


CREATE  INDEX sau_atendprest_descricao_in ON sau_atendprest(sd46_v_descricao);
CREATE UNIQUE INDEX sau_atividadeensino_descricao_in ON sau_atividadeensino(sd38_v_descricao);
CREATE  INDEX sau_convenio_descricao_in ON sau_convenio(sd49_v_descricao);
CREATE UNIQUE INDEX sau_esferaadmin_descricao_in ON sau_esferaadmin(sd37_v_descricao);
CREATE UNIQUE INDEX sau_fluxocliente_decricao_in ON sau_fluxocliente(sd41_v_descricao);
CREATE UNIQUE INDEX sau_gestaoativ_und_prg_ind_in ON sau_gestaoativ(sd47_i_unidade,sd47_i_programa,sd47_i_indgestao);
CREATE UNIQUE INDEX sau_natorg_descricao_in ON sau_natorg(sd40_v_descricao);
CREATE INDEX sau_nivelhier_descricao_in ON sau_nivelhier(sd44_v_descricao);
CREATE UNIQUE INDEX sau_orgaoemissor_codigo_in ON sau_orgaoemissor(sd51_i_codigo);
CREATE UNIQUE INDEX sau_retentributo_situacao_in ON sau_retentributo(sd39_v_situacao);
CREATE UNIQUE INDEX sau_vinculacao_vinc_subvin_in ON sau_subtpmodvinculo(sd54_i_vinculacao,sd54_i_tpvinculo,sd54_i_tpsubvinculo);
CREATE  INDEX sau_tipoatend_descricao_in ON sau_tipoatend(sd45_v_descricao);
CREATE UNIQUE INDEX sau_tipounidade_descricao_in ON sau_tipounidade(sd42_v_descricao);
CREATE UNIQUE INDEX sau_tpmodvinculo_vinculacao_tpvinculo_in ON sau_tpmodvinculo(sd53_i_vinculacao,sd53_i_tpvinculo);
CREATE  INDEX sau_turnoaten_descricao_in ON sau_turnoatend(sd43_v_descricao);





--alteração unidade

ALTER TABLE unidades add sd02_i_numcgm int4;
ALTER TABLE unidades add sd02_i_situacao int4;
ALTER TABLE unidades add sd02_v_cnes varchar(7);
ALTER TABLE unidades add sd02_v_microreg varchar(6);
ALTER TABLE unidades add sd02_v_distsant varchar(4);
ALTER TABLE unidades add sd02_v_distadmin varchar(4);
ALTER TABLE unidades add sd02_i_cod_esfadm int4;
ALTER TABLE unidades add sd02_i_cod_ativ int4;
ALTER TABLE unidades add sd02_i_reten_trib int4;
ALTER TABLE unidades add sd02_i_cod_natorg int4;
ALTER TABLE unidades add sd02_i_cod_client int4;
ALTER TABLE unidades add sd02_v_num_alvara varchar(60);
ALTER TABLE unidades add sd02_d_data_exped date default null;
ALTER TABLE unidades add sd02_v_ind_orgexp varchar(2);
ALTER TABLE unidades add sd02_i_tp_unid_id int4;
ALTER TABLE unidades add sd02_i_cod_turnat int4;
ALTER TABLE unidades add sd02_i_codnivhier int4;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_reten_fk FOREIGN KEY (sd02_i_reten_trib)
REFERENCES sau_retentributo;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_ativ_fk FOREIGN KEY (sd02_i_cod_ativ)
REFERENCES sau_atividadeensino;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_esfadm_fk FOREIGN KEY (sd02_i_cod_esfadm)
REFERENCES sau_esferaadmin;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_codnivhier_fk FOREIGN KEY (sd02_i_codnivhier)
REFERENCES sau_nivelhier;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_numcgm_fk FOREIGN KEY (sd02_i_numcgm)
REFERENCES cgm;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_turnat_fk FOREIGN KEY (sd02_i_cod_turnat)
REFERENCES sau_turnoatend;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_tpunid_fk FOREIGN KEY (sd02_i_tp_unid_id)
REFERENCES sau_tipounidade;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_cliente_fk FOREIGN KEY (sd02_i_cod_client)
REFERENCES sau_fluxocliente;

ALTER TABLE unidades
ADD CONSTRAINT unidades_i_natorg_fk FOREIGN KEY (sd02_i_cod_natorg)
REFERENCES sau_natorg;
