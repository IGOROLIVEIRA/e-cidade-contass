DROP TABLE sau_agravo CASCADE;
DROP TABLE sau_cid CASCADE;
DROP TABLE sau_complexidade CASCADE;
DROP TABLE sau_detalhe CASCADE;
DROP TABLE sau_execaocompatibilidade CASCADE;
DROP TABLE sau_financiamento CASCADE;
DROP TABLE sau_formaorganizacao CASCADE;
DROP TABLE sau_grupo CASCADE;
DROP TABLE sau_grupohabilitacao CASCADE;
DROP TABLE sau_habilitacao CASCADE;
DROP TABLE sau_modalidade CASCADE;
DROP TABLE sau_proccbo CASCADE;
DROP TABLE sau_proccid CASCADE;
DROP TABLE sau_proccompativel CASCADE;
DROP TABLE sau_procdetalhe CASCADE;
DROP TABLE sau_procedimento CASCADE;
DROP TABLE sau_prochabilitacao CASCADE;
DROP TABLE sau_procincremento CASCADE;
DROP TABLE sau_procleito CASCADE;
DROP TABLE sau_procmodalidade CASCADE;
DROP TABLE sau_prococupacao CASCADE;
DROP TABLE sau_procorigem CASCADE;
DROP TABLE sau_procregistro CASCADE;
DROP TABLE sau_procservico CASCADE;
DROP TABLE sau_procsiasih CASCADE;
DROP TABLE sau_registro CASCADE;
DROP TABLE sau_rubrica CASCADE;
DROP TABLE sau_servclassificacao CASCADE;
DROP TABLE sau_servico CASCADE;
DROP TABLE sau_siasih CASCADE;
DROP TABLE sau_subgrupo CASCADE;
DROP TABLE sau_tipocompatibilidade CASCADE;
DROP TABLE sau_tipoleito CASCADE;
DROP TABLE sau_tipoproc CASCADE;
--Criando drop sequences
DROP SEQUENCE sau_agravo_sd71_i_codigo_seq;
DROP SEQUENCE sau_cid_sd70_i_codigo_seq;
DROP SEQUENCE sau_complexidade_sd69_i_codigo_seq;
DROP SEQUENCE sau_detalhe_sd73_i_codigo_seq;
DROP SEQUENCE sau_execaocompatibilidade_sd67_i_codigo_seq;
DROP SEQUENCE sau_financiamento_sd65_i_codigo_seq;
DROP SEQUENCE sau_formaorganizacao_sd62_i_codigo_seq;
DROP SEQUENCE sau_grupo_sd60_i_codigo_seq;
DROP SEQUENCE sau_grupohabilitacao_sd76_i_codigo_seq;
DROP SEQUENCE sau_habilitacao_sd75_i_codigo_seq;
DROP SEQUENCE sau_modalidade_sd82_i_codigo_seq;
DROP SEQUENCE sau_proccbo_sd96_i_codigo_seq;
DROP SEQUENCE sau_proccid_sd72_i_codigo_seq;
DROP SEQUENCE sau_proccompativel_sd66_i_codigo_seq;
DROP SEQUENCE sau_procdetalhe_sd74_i_codigo_seq;
DROP SEQUENCE sau_procedimento_sd63_i_codigo_seq;
DROP SEQUENCE sau_prochabilitacao_sd77_i_codigo_seq;
DROP SEQUENCE sau_procinremento_sd79_i_codigo_seq;
DROP SEQUENCE sau_procleito_sd81_i_codig_seq;
DROP SEQUENCE sau_procmodalidade_sd83_i_codigo_seq;
DROP SEQUENCE sau_prococupacao_sd90_i_codigo_seq;
DROP SEQUENCE sau_procorigem_sd95_i_codigo_seq;
DROP SEQUENCE sau_procservico_sd88_i_codigo_seq;
DROP SEQUENCE sau_procsiasih_sd94_i_codigo_seq;
DROP SEQUENCE sau_registro_sd84_i_codigo_seq;
DROP SEQUENCE sau_rubrica_sd64_i_codigo_seq;
DROP SEQUENCE sau_servclassificacao_sd87_i_codigo_seq;
DROP SEQUENCE sau_servico_sd86_i_codigo_seq;
DROP SEQUENCE sau_siasih_sd92_i_codigo_seq;
DROP SEQUENCE sau_subgrupo_sd61_i_codigo_seq;
DROP SEQUENCE sau_tipocompatibilidade_sd68_i_codigo_seq;
DROP SEQUENCE sau_tipoleito_sd80_i_codigo_seq;
DROP SEQUENCE sau_tipoproc_sd93_i_codigo_seq;


-- Criando  sequences
create sequence sau_procregistro_sd85_i_codigo_seq;

CREATE SEQUENCE sau_agravo_sd71_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_cid_sd70_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_complexidade_sd69_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_detalhe_sd73_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_execaocompatibilidade_sd67_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_financiamento_sd65_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_formaorganizacao_sd62_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_grupo_sd60_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_grupohabilitacao_sd76_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_habilitacao_sd75_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_modalidade_sd82_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_proccbo_sd96_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_proccid_sd72_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_proccompativel_sd66_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procdetalhe_sd74_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procedimento_sd63_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_prochabilitacao_sd77_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procinremento_sd79_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procleito_sd81_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procmodalidade_sd83_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_prococupacao_sd90_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procorigem_sd95_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procservico_sd88_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_procsiasih_sd94_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_registro_sd84_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_rubrica_sd64_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_servclassificacao_sd87_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_servico_sd86_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_subgrupo_sd61_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE sau_siasih_sd92_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_tipocompatibilidade_sd68_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_tipoleito_sd80_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sau_tipoproc_sd93_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: saude
CREATE TABLE sau_agravo(
sd71_i_codigo		int8 default 0,
sd71_c_nome		varchar(60) ,
CONSTRAINT sau_agravo_codi_pk PRIMARY KEY (sd71_i_codigo));


-- Módulo: saude
CREATE TABLE sau_cid(
sd70_i_codigo		int8 default 0,
sd70_c_cid		varchar(4) ,
sd70_c_nome		varchar(100) ,
sd70_i_agravo		int8 default 0,
sd70_c_sexo		varchar(1) ,
CONSTRAINT sau_cid_codi_pk PRIMARY KEY (sd70_i_codigo));


-- Módulo: saude
CREATE TABLE sau_complexidade(
sd69_i_codigo		int8 default 0,
sd69_c_nome		varchar(60) ,
CONSTRAINT sau_complexidade_codi_pk PRIMARY KEY (sd69_i_codigo));


-- Módulo: saude
CREATE TABLE sau_detalhe(
sd73_i_codigo		int8 default 0,
sd73_c_detalhe		varchar(3) ,
sd73_c_nome		varchar(100) ,
sd73_i_anocomp		int4 default 0,
sd73_i_mescomp		int4 default 0,
CONSTRAINT sau_detalhe_codi_pk PRIMARY KEY (sd73_i_codigo));


-- Módulo: saude
CREATE TABLE sau_execaocompatibilidade(
sd67_i_codigo		int8 default 0,
sd67_i_procrestricao		int8 default 0,
sd67_i_procprincipal		int8 default 0,
sd67_i_regprincipal		int8 default 0,
sd67_i_proccompativel		int8 default 0,
sd67_i_regcompativel		int8 default 0,
sd67_i_compatibilidade		int8 default 0,
sd67_i_anocomp		int4 default 0,
sd67_i_mescomp		int4 default 0,
CONSTRAINT sau_execaocompatibilidade_codi_pk PRIMARY KEY (sd67_i_codigo));


-- Módulo: saude
CREATE TABLE sau_financiamento(
sd65_i_codigo		int4 default 0,
sd65_c_financiamento		varchar(2) ,
sd65_c_nome		varchar(100) ,
sd65_i_anocomp		int4 default 0,
sd65_i_mescomp		int4 default 0,
CONSTRAINT sau_financiamento_codi_pk PRIMARY KEY (sd65_i_codigo));


-- Módulo: saude
CREATE TABLE sau_formaorganizacao(
sd62_i_codigo		int8 default 0,
sd62_i_grupo		int8 default 0,
sd62_i_subgrupo		int8 default 0,
sd62_c_formaorganizacao		varchar(2) ,
sd62_c_nome		varchar(100) ,
sd62_i_anocomp		int4 default 0,
sd62_i_mescomp		int4 default 0,
CONSTRAINT sau_formaorganizacao_codi_pk PRIMARY KEY (sd62_i_codigo));


-- Módulo: saude
CREATE TABLE sau_grupo(
sd60_i_codigo		int8 default 0,
sd60_c_grupo		varchar(2) ,
sd60_c_nome		varchar(100) ,
sd60_i_anocomp		int4 default 0,
sd60_i_mescomp		int4 default 0,
CONSTRAINT sau_grupo_codi_pk PRIMARY KEY (sd60_i_codigo));


-- Módulo: saude
CREATE TABLE sau_grupohabilitacao(
sd76_i_codigo		int8 default 0,
sd76_c_grupohabilitacao		varchar(20) ,
sd76_i_habilitacao		int8 default 0,
sd76_c_descricao		varchar(250) ,
CONSTRAINT sau_grupohabilitacao_codi_pk PRIMARY KEY (sd76_i_codigo));


-- Módulo: saude
CREATE TABLE sau_habilitacao(
sd75_i_codigo		int8 default 0,
sd75_c_habilitacao		varchar(4) ,
sd75_c_nome		varchar(150) ,
sd75_i_anocomp		int4 default 0,
sd75_i_mescomp		int4 default 0,
CONSTRAINT sau_habilitacao_codi_pk PRIMARY KEY (sd75_i_codigo));


-- Módulo: saude
CREATE TABLE sau_modalidade(
sd82_i_codigo		int8 default 0,
sd82_c_modalidade		varchar(2) ,
sd82_c_nome		varchar(100) ,
sd82_i_anocomp		int4 default 0,
sd82_i_mescomp		int4 default 0,
CONSTRAINT sau_modalidade_codi_pk PRIMARY KEY (sd82_i_codigo));


-- Módulo: saude
CREATE TABLE sau_proccbo(
sd96_i_codigo		int8 default 0,
sd96_i_procedimento		int8 default 0,
sd96_i_cbo		int4 default 0,
sd96_i_anocomp		int4 default 0,
sd96_i_mescomp		int4 default 0,
CONSTRAINT sau_proccbo_codi_pk PRIMARY KEY (sd96_i_codigo));


-- Módulo: saude
CREATE TABLE sau_proccid(
sd72_i_codigo		int8 default 0,
sd72_i_procedimento		int8 default 0,
sd72_i_cid		int8 default 0,
sd72_c_principal		varchar(1) ,
sd72_i_anocomp		int4 default 0,
sd72_i_mescomp		int4 default 0,
CONSTRAINT sau_proccid_codi_pk PRIMARY KEY (sd72_i_codigo));


-- Módulo: saude
CREATE TABLE sau_proccompativel(
sd66_i_codigo		int8 default 0,
sd66_i_procprincipal		int8 default 0,
sd66_i_regprincipal		int8 default 0,
sd66_i_proccompativel		int8 default 0,
sd66_i_regcompativel		int8 default 0,
sd66_i_compatibilidade		int8 default 0,
sd66_i_qtd		int8 default 0,
sd66_i_anocomp		int4 default 0,
sd66_i_mescomp		int4 default 0,
CONSTRAINT sau_proccompativel_codi_pk PRIMARY KEY (sd66_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procdetalhe(
sd74_i_codigo		int8 default 0,
sd74_i_procedimento		int8 default 0,
sd74_i_detalhe		int4 default 0,
sd74_i_anocomp		int4 default 0,
sd74_i_mescomp		int4 default 0,
CONSTRAINT sau_procdetalhe_codi_pk PRIMARY KEY (sd74_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procedimento(
sd63_i_codigo		int8 default 0,
sd63_c_procedimento		varchar(10) ,
sd63_c_nome		varchar(250) ,
sd63_i_complexidade		int8 default 0,
sd63_c_sexo		varchar(1) ,
sd63_i_execucaomax		int8 default 0,
sd63_i_maxdias		int8 default 0,
sd63_i_pontos		int8 default 0,
sd63_i_idademin		int8 default 0,
sd63_i_idademax		int8 default 0,
sd63_f_sh		float8 default 0,
sd63_f_sa		float8 default 0,
sd63_f_sp		float8 default 0,
sd63_i_financiamento		int8 default 0,
sd63_i_rubrica		int8 default 0,
sd63_i_anocomp		int4 default 0,
sd63_i_mescomp		int4 default 0,
CONSTRAINT sau_procedimento_codi_pk PRIMARY KEY (sd63_i_codigo));


-- Módulo: saude
CREATE TABLE sau_prochabilitacao(
sd77_i_codigo		int8 default 0,
sd77_i_procedimento		int8 default 0,
sd77_i_habilitacao		int8 default 0,
sd77_i_grupohabilitacao		int8 default 0,
sd77_i_anocomp		int4 default 0,
sd77_i_mescomp		int4 default 0,
CONSTRAINT sau_prochabilitacao_codi_pk PRIMARY KEY (sd77_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procincremento(
sd79_i_codigo		int8 default 0,
sd79_i_procedimento		int8 default 0,
sd79_i_habilitacao		int8 default 0,
sd79_f_sh		float8 default 0,
sd79_f_sa		float8 default 0,
sd79_f_sp		float8 default 0,
sd79_i_anocomp		int4 default 0,
sd79_i_mescomp		int4 default 0,
CONSTRAINT sau_procincremento_codi_pk PRIMARY KEY (sd79_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procleito(
sd81_i_codigo		int8 default 0,
sd81_i_procedimento		int8 default 0,
sd81_i_leito		int8 default 0,
sd81_i_anocomp		int4 default 0,
sd81_i_mescomp		int4 default 0,
CONSTRAINT sau_procleito_codi_pk PRIMARY KEY (sd81_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procmodalidade(
sd83_i_codigo		int8 default 0,
sd83_i_procedimento		int8 default 0,
sd83_i_modalidade		int8 default 0,
sd83_i_anocomp		int4 default 0,
sd83_i_mescomp		int4 default 0,
CONSTRAINT sau_procmodalidade_codi_pk PRIMARY KEY (sd83_i_codigo));


-- Módulo: saude
CREATE TABLE sau_prococupacao(
sd90_i_codigo		int8 default 0,
sd90_i_procedimento		int8 default 0,
sd90_i_ocupacao		int8 default 0,
sd90_i_anocomp		int4 default 0,
sd90_i_mescomp		int4 default 0,
CONSTRAINT sau_prococupacao_codi_pk PRIMARY KEY (sd90_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procorigem(
sd95_i_codigo		int8 default 0,
sd95_i_procedimento		int8 default 0,
sd95_i_origem		int8 default 0,
sd95_i_anocomp		int4 default 0,
sd95_i_mescomp		int4 default 0,
CONSTRAINT sau_procorigem_codi_pk PRIMARY KEY (sd95_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procregistro(
sd85_i_codigo		int8 default 0,
sd85_i_procedimento		int8 default 0,
sd85_i_registro		int8 default 0,
sd85_i_anocomp		int4 default 0,
sd85_i_mescomp		int4 default 0,
CONSTRAINT sau_procregistro_codi_pk PRIMARY KEY (sd85_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procservico(
sd88_i_codigo		int8 default 0,
sd88_i_procedimento		int8 default 0,
sd88_i_classificacao		int8 default 0,
sd88_i_servico		int8 default 0,
sd88_i_anocomp		int4 default 0,
sd88_i_mescomp		int4 default 0,
CONSTRAINT sau_procservico_codi_pk PRIMARY KEY (sd88_i_codigo));


-- Módulo: saude
CREATE TABLE sau_procsiasih(
sd94_i_codigo		int8 default 0,
sd94_i_procedimento		int8 default 0,
sd94_i_siasih		int8 default 0,
sd94_i_tipoproc		int8 default 0,
sd94_i_anocomp		int4 default 0,
sd94_i_mescomp		int4 default 0,
CONSTRAINT sau_procsiasih_codi_pk PRIMARY KEY (sd94_i_codigo));


-- Módulo: saude
CREATE TABLE sau_registro(
sd84_i_codigo		int8 default 0,
sd84_c_registro		varchar(2) ,
sd84_c_nome		varchar(50) ,
sd84_i_anocomp		int4 default 0,
sd84_i_mescomp		int4 default 0,
CONSTRAINT sau_registro_codi_pk PRIMARY KEY (sd84_i_codigo));


-- Módulo: saude
CREATE TABLE sau_rubrica(
sd64_i_codigo		int8 default 0,
sd64_c_rubrica		varchar(6) ,
sd64_c_nome		varchar(100) ,
sd64_i_anocomp		int4 default 0,
sd64_i_mescomp		int4 default 0,
CONSTRAINT sau_rubrica_codi_pk PRIMARY KEY (sd64_i_codigo));


-- Módulo: saude
CREATE TABLE sau_servclassificacao(
sd87_i_codigo		int8 default 0,
sd87_c_classificacao		varchar(3) ,
sd87_c_nome		varchar(150) ,
sd87_i_servico		int8 default 0,
sd87_i_anocomp		int4 default 0,
sd87_i_mescomp		int4 default 0,
CONSTRAINT sau_servclassificacao_codi_pk PRIMARY KEY (sd87_i_codigo));


-- Módulo: saude
CREATE TABLE sau_servico(
sd86_i_codigo		int8 default 0,
sd86_c_servico		varchar(3) ,
sd86_c_nome		varchar(120) ,
sd86_i_anocomp		int4 default 0,
sd86_i_mescomp		int4 default 0,
CONSTRAINT sau_servico_codi_pk PRIMARY KEY (sd86_i_codigo));


-- Módulo: saude
CREATE TABLE sau_siasih(
sd92_i_codigo		int8 default 0,
sd92_c_siasih		varchar(10) ,
sd92_c_nome		varchar(100) ,
sd92_i_tipoproc		int8 default 0,
sd92_i_anocomp		int4 default 0,
sd92_i_mescomp		int4 default 0,
CONSTRAINT sau_siasih_codi_pk PRIMARY KEY (sd92_i_codigo));


-- Módulo: saude
CREATE TABLE sau_subgrupo(
sd61_i_codigo		int8 default 0,
sd61_c_subgrupo		varchar(2) ,
sd61_i_grupo		int8 default 0,
sd61_c_nome		varchar(100) ,
sd61_i_anocomp		int4 default 0,
sd61_i_mescomp		int4 default 0,
CONSTRAINT sau_subgrupo_codi_pk PRIMARY KEY (sd61_i_codigo));


-- Módulo: saude
CREATE TABLE sau_tipocompatibilidade(
sd68_i_codigo		int8 default 0,
sd68_c_nome		varchar(50) ,
CONSTRAINT sau_tipocompatibilidade_codi_pk PRIMARY KEY (sd68_i_codigo));


-- Módulo: saude
CREATE TABLE sau_tipoleito(
sd80_i_codigo		int8 default 0,
sd80_c_leito		varchar(2) ,
sd80_c_nome		varchar(60) ,
sd80_i_anocomp		int4 default 0,
sd80_i_mescomp		int4 default 0,
CONSTRAINT sau_tipoleito_codi_pk PRIMARY KEY (sd80_i_codigo));


-- Módulo: saude
CREATE TABLE sau_tipoproc(
sd93_i_codigo		int8 default 0,
sd93_c_nome		varchar(50) ,
CONSTRAINT sau_tipoproc_codi_pk PRIMARY KEY (sd93_i_codigo));




-- CHAVE ESTRANGEIRA


ALTER TABLE sau_execaocompatibilidade
ADD CONSTRAINT sau_execaocompatibilidade_i_regprincipal_i_regcompativel_fk FOREIGN KEY (sd67_i_regprincipal,sd67_i_regcompativel)
REFERENCES sau_registro;

ALTER TABLE sau_execaocompatibilidade
ADD CONSTRAINT sau_execaocompatibilidade_i_compatibilidade_fk FOREIGN KEY (sd67_i_compatibilidade)
REFERENCES sau_tipocompatibilidade;

ALTER TABLE sau_execaocompatibilidade
ADD CONSTRAINT sau_execaocompatibilidade_i_procrestricao_i_procprincipal_i_proccompativel_fk FOREIGN KEY (sd67_i_procrestricao,sd67_i_procprincipal,sd67_i_proccompativel)
REFERENCES sau_procedimento;

ALTER TABLE sau_formaorganizacao
ADD CONSTRAINT sau_formaorganizacao_i_grupo_fk FOREIGN KEY (sd62_i_grupo)
REFERENCES sau_grupo;

ALTER TABLE sau_formaorganizacao
ADD CONSTRAINT sau_formaorganizacao_i_subgrupo_fk FOREIGN KEY (sd62_i_subgrupo)
REFERENCES sau_subgrupo;

ALTER TABLE sau_grupohabilitacao
ADD CONSTRAINT sau_grupohabilitacao_i_habilitacao_fk FOREIGN KEY (sd76_i_habilitacao)
REFERENCES sau_habilitacao;

ALTER TABLE sau_proccbo
ADD CONSTRAINT sau_proccbo_i_procedimento_fk FOREIGN KEY (sd96_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_proccbo
ADD CONSTRAINT sau_proccbo_i_cbo_fk FOREIGN KEY (sd96_i_cbo)
REFERENCES rhcbo;

ALTER TABLE sau_proccid
ADD CONSTRAINT sau_proccid_i_procedimento_fk FOREIGN KEY (sd72_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_proccid
ADD CONSTRAINT sau_proccid_i_cid_fk FOREIGN KEY (sd72_i_cid)
REFERENCES sau_cid;

ALTER TABLE sau_proccompativel
ADD CONSTRAINT sau_proccompativel_i_regprincipal_i_regcompativel_fk FOREIGN KEY (sd66_i_regprincipal,sd66_i_regcompativel)
REFERENCES sau_registro;

ALTER TABLE sau_proccompativel
ADD CONSTRAINT sau_proccompativel_i_compatibilidade_fk FOREIGN KEY (sd66_i_compatibilidade)
REFERENCES sau_tipocompatibilidade;

ALTER TABLE sau_proccompativel
ADD CONSTRAINT sau_proccompativel_i_procprincipal_i_proccompativel_fk FOREIGN KEY (sd66_i_procprincipal,sd66_i_proccompativel)
REFERENCES sau_procedimento;

ALTER TABLE sau_procdetalhe
ADD CONSTRAINT sau_procdetalhe_i_detalhe_fk FOREIGN KEY (sd74_i_detalhe)
REFERENCES sau_detalhe;

ALTER TABLE sau_procdetalhe
ADD CONSTRAINT sau_procdetalhe_i_procedimento_fk FOREIGN KEY (sd74_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procedimento
ADD CONSTRAINT sau_procedimento_i_rubrica_fk FOREIGN KEY (sd63_i_rubrica)
REFERENCES sau_rubrica;

ALTER TABLE sau_procedimento
ADD CONSTRAINT sau_procedimento_i_financiamento_fk FOREIGN KEY (sd63_i_financiamento)
REFERENCES sau_financiamento;

ALTER TABLE sau_procedimento
ADD CONSTRAINT sau_procedimento_i_complexidade_fk FOREIGN KEY (sd63_i_complexidade)
REFERENCES sau_complexidade;

ALTER TABLE sau_prochabilitacao
ADD CONSTRAINT sau_prochabilitacao_i_habilitacao_fk FOREIGN KEY (sd77_i_habilitacao)
REFERENCES sau_habilitacao;

ALTER TABLE sau_prochabilitacao
ADD CONSTRAINT sau_prochabilitacao_i_grupohabilitacao_fk FOREIGN KEY (sd77_i_grupohabilitacao)
REFERENCES sau_grupohabilitacao;

ALTER TABLE sau_prochabilitacao
ADD CONSTRAINT sau_prochabilitacao_i_procedimento_fk FOREIGN KEY (sd77_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procincremento
ADD CONSTRAINT sau_procincremento_i_procedimento_fk FOREIGN KEY (sd79_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procincremento
ADD CONSTRAINT sau_procincremento_i_habilitacao_fk FOREIGN KEY (sd79_i_habilitacao)
REFERENCES sau_habilitacao;

ALTER TABLE sau_procleito
ADD CONSTRAINT sau_procleito_i_procedimento_fk FOREIGN KEY (sd81_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procleito
ADD CONSTRAINT sau_procleito_i_leito_fk FOREIGN KEY (sd81_i_leito)
REFERENCES sau_tipoleito;

ALTER TABLE sau_procmodalidade
ADD CONSTRAINT sau_procmodalidade_i_modalidade_fk FOREIGN KEY (sd83_i_modalidade)
REFERENCES sau_modalidade;

ALTER TABLE sau_procmodalidade
ADD CONSTRAINT sau_procmodalidade_i_procedimento_fk FOREIGN KEY (sd83_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_prococupacao
ADD CONSTRAINT sau_prococupacao_i_ocupacao_fk FOREIGN KEY (sd90_i_ocupacao)
REFERENCES sau_ocupacao;

ALTER TABLE sau_prococupacao
ADD CONSTRAINT sau_prococupacao_i_procedimento_fk FOREIGN KEY (sd90_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procorigem
ADD CONSTRAINT sau_procorigem_i_procedimento_i_origem_fk FOREIGN KEY (sd95_i_procedimento,sd95_i_origem)
REFERENCES sau_procedimento;

ALTER TABLE sau_procregistro
ADD CONSTRAINT sau_procregistro_i_registro_fk FOREIGN KEY (sd85_i_registro)
REFERENCES sau_registro;

ALTER TABLE sau_procregistro
ADD CONSTRAINT sau_procregistro_i_procedimento_fk FOREIGN KEY (sd85_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procservico
ADD CONSTRAINT sau_procservico_i_servico_fk FOREIGN KEY (sd88_i_servico)
REFERENCES sau_servico;

ALTER TABLE sau_procservico
ADD CONSTRAINT sau_procservico_i_classificacao_fk FOREIGN KEY (sd88_i_classificacao)
REFERENCES sau_servclassificacao;

ALTER TABLE sau_procservico
ADD CONSTRAINT sau_procservico_i_procedimento_fk FOREIGN KEY (sd88_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_procsiasih
ADD CONSTRAINT sau_procsiasih_i_siasih_fk FOREIGN KEY (sd94_i_siasih)
REFERENCES sau_siasih;

ALTER TABLE sau_procsiasih
ADD CONSTRAINT sau_procsiasih_i_tipoproc_fk FOREIGN KEY (sd94_i_tipoproc)
REFERENCES sau_tipoproc;

ALTER TABLE sau_procsiasih
ADD CONSTRAINT sau_procsiasih_i_procedimento_fk FOREIGN KEY (sd94_i_procedimento)
REFERENCES sau_procedimento;

ALTER TABLE sau_servclassificacao
ADD CONSTRAINT sau_servclassificacao_i_servico_fk FOREIGN KEY (sd87_i_servico)
REFERENCES sau_servico;

ALTER TABLE sau_siasih
ADD CONSTRAINT sau_siasih_i_tipoproc_fk FOREIGN KEY (sd92_i_tipoproc)
REFERENCES sau_tipoproc;

ALTER TABLE sau_subgrupo
ADD CONSTRAINT sau_subgrupo_i_grupo_fk FOREIGN KEY (sd61_i_grupo)
REFERENCES sau_grupo;




-- INDICES


CREATE UNIQUE INDEX sau_agravo_nome_unique ON sau_agravo(sd71_c_nome);

CREATE UNIQUE INDEX sau_cid_unique ON sau_cid(sd70_c_cid,sd70_c_nome);

CREATE UNIQUE INDEX sau_complexidade_unique_in ON sau_complexidade(sd69_c_nome);

CREATE UNIQUE INDEX sau_detalhe_competencia_in ON sau_detalhe(sd73_c_detalhe,sd73_i_anocomp,sd73_i_mescomp);

CREATE UNIQUE INDEX sau_execaocompatibilidade_competencia_in ON sau_execaocompatibilidade(sd67_i_procrestricao,sd67_i_procprincipal,sd67_i_proccompativel,sd67_i_anocomp,sd67_i_mescomp);

CREATE UNIQUE INDEX sau_financiamento_competencia_in ON sau_financiamento(sd65_c_financiamento,sd65_i_anocomp);

CREATE UNIQUE INDEX sau_formaorganizacao_competencia_in ON sau_formaorganizacao(sd62_i_grupo,sd62_i_subgrupo,sd62_c_formaorganizacao,sd62_i_anocomp,sd62_i_mescomp);

CREATE UNIQUE INDEX sau_grupo_competencia_in ON sau_grupo(sd60_c_grupo,sd60_i_anocomp,sd60_i_mescomp);

CREATE UNIQUE INDEX sau_grupohabilitacao_unique_in ON sau_grupohabilitacao(sd76_c_grupohabilitacao,sd76_c_descricao,sd76_i_habilitacao);

CREATE UNIQUE INDEX sau_habilitacao_competencia_in ON sau_habilitacao(sd75_c_habilitacao,sd75_i_anocomp,sd75_i_mescomp);

CREATE UNIQUE INDEX sau_modalidade_competencia_in ON sau_modalidade(sd82_c_modalidade,sd82_i_anocomp,sd82_i_mescomp);

CREATE UNIQUE INDEX sau_proccob_competencia_in ON sau_proccbo(sd96_i_procedimento,sd96_i_cbo,sd96_i_anocomp,sd96_i_mescomp);

CREATE UNIQUE INDEX sau_procid_competencia_in ON sau_proccid(sd72_i_procedimento,sd72_i_cid,sd72_c_principal,sd72_i_anocomp,sd72_i_mescomp);

CREATE UNIQUE INDEX sau_porccompativel_competencia_in ON sau_proccompativel(sd66_i_procprincipal,sd66_i_regprincipal,sd66_i_proccompativel,sd66_i_regcompativel,sd66_i_anocomp,sd66_i_mescomp);

CREATE UNIQUE INDEX sau_procdetalhe_competencia_in ON sau_procdetalhe(sd74_i_procedimento,sd74_i_detalhe,sd74_i_anocomp,sd74_i_mescomp);

CREATE UNIQUE INDEX sau_procedimento_competencia_in ON sau_procedimento(sd63_c_procedimento,sd63_i_anocomp,sd63_i_mescomp);

CREATE UNIQUE INDEX sau_prochabilitacao_competencia_in ON sau_prochabilitacao(sd77_i_procedimento,sd77_i_habilitacao,sd77_i_grupohabilitacao,sd77_i_anocomp,sd77_i_mescomp);

CREATE UNIQUE INDEX sau_procincremento_competencia_in ON sau_procincremento(sd79_i_procedimento,sd79_i_habilitacao,sd79_i_anocomp,sd79_i_mescomp);

CREATE UNIQUE INDEX sau_procleito_competencia_in ON sau_procleito(sd81_i_procedimento,sd81_i_leito,sd81_i_anocomp,sd81_i_mescomp);

CREATE UNIQUE INDEX sau_procmodalidade_competencia_in ON sau_procmodalidade(sd83_i_procedimento,sd83_i_modalidade,sd83_i_anocomp,sd83_i_mescomp);

CREATE UNIQUE INDEX sau_prococupacao_competencia_in ON sau_prococupacao(sd90_i_procedimento,sd90_i_ocupacao,sd90_i_anocomp,sd90_i_mescomp);

CREATE UNIQUE INDEX sau_procorigem_competencia_in ON sau_procorigem(sd95_i_procedimento,sd95_i_origem,sd95_i_anocomp,sd95_i_mescomp);

CREATE UNIQUE INDEX sau_procregistro_competencia_in ON sau_procregistro(sd85_i_procedimento,sd85_i_registro,sd85_i_anocomp,sd85_i_mescomp);

CREATE UNIQUE INDEX sau_procservico_competencia_in ON sau_procservico(sd88_i_procedimento,sd88_i_classificacao,sd88_i_servico,sd88_i_anocomp,sd88_i_mescomp);

CREATE UNIQUE INDEX sau_procsiasih_competencia_in ON sau_procsiasih(sd94_i_procedimento,sd94_i_anocomp,sd94_i_mescomp,sd94_i_siasih,sd94_i_tipoproc);

CREATE UNIQUE INDEX sau_registro_competencia ON sau_registro(sd84_c_registro,sd84_i_anocomp,sd84_i_mescomp);

CREATE UNIQUE INDEX sau_rubrica_competencia_in ON sau_rubrica(sd64_c_rubrica,sd64_i_anocomp,sd64_i_mescomp);

CREATE UNIQUE INDEX sau_servclassificacao_competencia_in ON sau_servclassificacao(sd87_c_classificacao,sd87_i_servico,sd87_i_mescomp,sd87_i_anocomp);

CREATE UNIQUE INDEX sau_servico_competencia_in ON sau_servico(sd86_c_servico,sd86_i_anocomp,sd86_i_mescomp);

CREATE UNIQUE INDEX sau_siasih_competencia_in ON sau_siasih(sd92_c_siasih,sd92_i_tipoproc,sd92_i_anocomp,sd92_i_mescomp);

CREATE UNIQUE INDEX sau_saubgrupo_competencia_in ON sau_subgrupo(sd61_c_subgrupo,sd61_i_grupo,sd61_c_nome,sd61_i_anocomp,sd61_i_mescomp);

CREATE UNIQUE INDEX sau_tipocompatibilidade_nome_unique_in ON sau_tipocompatibilidade(sd68_c_nome);

CREATE UNIQUE INDEX sau_tipoleito_competencia_unique_in ON sau_tipoleito(sd80_c_leito,sd80_i_anocomp,sd80_i_mescomp);

CREATE UNIQUE INDEX sau_tipoproc_nome_unique_in ON sau_tipoproc(sd93_c_nome);

