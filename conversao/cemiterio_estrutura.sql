--sql a ser executado na base de dados
--DROP TABLE:
DROP TABLE campas;
DROP TABLE causa;
DROP TABLE cemiterio;
DROP TABLE cemiteriocgm;
DROP TABLE cemiteriorural;
DROP TABLE funerarias;
DROP TABLE gavetas;
DROP TABLE gavetas_old;
DROP TABLE hospitais;
DROP TABLE itenserv;
DROP TABLE jazigos;
DROP TABLE lotecemit;
DROP TABLE ossoario;
DROP TABLE ossoariojazigo;
DROP TABLE ossoariopart;
DROP TABLE propricemit;
DROP TABLE proprijazigo;
DROP TABLE quadracemit;
DROP TABLE renovacoes;
DROP TABLE restosgavetas;
DROP TABLE restos_old;
DROP TABLE retiradas;
DROP TABLE sepulta;
DROP TABLE sepultamentos;
DROP TABLE sepulthist;
DROP TABLE sepulturas;
DROP TABLE taxaserv;
DROP TABLE txossoariojazigo;
DROP TABLE txsepultamentos;
DROP TABLE legista;
--Criando drop sequences
DROP SEQUENCE cem_legista_seq;
DROP SEQUENCE campas_cm19_i_codigo_seq;
DROP SEQUENCE causa_cm04_i_codigo_seq;
DROP SEQUENCE cemiterio_cm14_i_codigo_seq;
DROP SEQUENCE gavetas_cm27_i_codigo_seq;
DROP SEQUENCE gavetas_old_cm13_i_codigo_seq;
DROP SEQUENCE itenserv_cm10_i_codigo_seq;
DROP SEQUENCE jazigos_cm03_i_codigo_seq;
DROP SEQUENCE lotecemit_cm23_i_codigo_seq;
DROP SEQUENCE ossoario_cm06_i_codigo_seq;
DROP SEQUENCE ossoariojazigo_cm25_i_codigo_seq;
DROP SEQUENCE ossoariopart_cm02_i_codigo_seq;
DROP SEQUENCE propricemit_cm28_i_codigo_seq;
DROP SEQUENCE proprijazigo_cm29_i_codigo_seq;
DROP SEQUENCE quadracemit_cm22_i_codigo_seq;
DROP SEQUENCE renovacoes_cm07_i_codigo_seq;
DROP SEQUENCE restosgavetas_cm26_i_codigo_seq;
DROP SEQUENCE restos_old_cm12_i_codigo_seq;
DROP SEQUENCE retiradas_cm08_i_codigo_seq;
DROP SEQUENCE sepulta_cm24_i_codigo_seq;
DROP SEQUENCE sepulthist_cm21_i_codigo_seq;
DROP SEQUENCE sepulturas_cm05_i_codigo_seq;
DROP SEQUENCE taxaserv_cm11_i_codigo_seq;
DROP SEQUENCE txossoariojazigo_cm30_i_codigo_seq;
DROP SEQUENCE txsepultamentos_cm31_i_codigo_seq;


-- Criando  sequences
CREATE SEQUENCE campas_cm19_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE causa_cm04_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE cemiterio_cm14_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE gavetas_cm27_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE gavetas_old_cm13_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE itenserv_cm10_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE jazigos_cm03_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE cem_legista_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE lotecemit_cm23_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE ossoario_cm06_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE ossoariojazigo_cm25_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE ossoariopart_cm02_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE propricemit_cm28_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE proprijazigo_cm29_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE quadracemit_cm22_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE renovacoes_cm07_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE restosgavetas_cm26_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE restos_old_cm12_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE retiradas_cm08_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sepulta_cm24_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sepulthist_cm21_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE sepulturas_cm05_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE taxaserv_cm11_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE txossoariojazigo_cm30_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE txsepultamentos_cm31_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- M&#65533;dulo: Cemiterio
CREATE TABLE campas(
cm19_i_codigo		int4 default 0,
cm19_c_descr		char(40) ,
CONSTRAINT campas_codi_pk PRIMARY KEY (cm19_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE causa(
cm04_i_codigo		int4 default 0,
cm04_c_descr		char(200) ,
CONSTRAINT causa_codi_pk PRIMARY KEY (cm04_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE cemiterio(
cm14_i_codigo		int4 default 0,
CONSTRAINT cemiterio_codi_pk PRIMARY KEY (cm14_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE cemiteriocgm(
cm15_i_cemiterio		int4 default 0,
cm15_i_cgm		int4 default 0,
CONSTRAINT cemiteriocgm_cemi_pk PRIMARY KEY (cm15_i_cemiterio));


-- M&#65533;dulo: Cemiterio
CREATE TABLE cemiteriorural(
cm16_i_cemiterio		int4 default 0,
cm16_c_nome		char(100) ,
cm16_c_endereco		char(80) ,
cm16_c_cidade		char(80) ,
cm16_c_bairro		char(50) ,
cm16_c_cep		char(10) ,
cm16_c_telefone		char(14) ,
CONSTRAINT cemiteriorural_cemi_pk PRIMARY KEY (cm16_i_cemiterio));


-- M&#65533;dulo: Cemiterio
CREATE TABLE funerarias(
cm17_i_funeraria		int4 default 0,
CONSTRAINT funerarias_fune_pk PRIMARY KEY (cm17_i_funeraria));


-- M&#65533;dulo: Cemiterio
CREATE TABLE gavetas(
cm27_i_codigo		int4 default 0,
cm27_i_restogaveta		int4 default 0,
cm27_d_exumprevista		date default null,
cm27_d_exumfeita		date default null,
cm27_c_ossoario		char(1) default 'N',
cm27_i_gaveta		int4 default 0,
CONSTRAINT gavetas_codi_pk PRIMARY KEY (cm27_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE gavetas_old(
cm13_i_codigo		int4 default 0,
cm13_i_jazigo		int4 default 0,
cm13_i_sepultamento		int4 default 0,
cm13_i_gaveta		int4 default 0,
cm13_i_medico		int4 default 0,
cm13_d_exumprevista		date default null,
cm13_d_exumfeita		date default null,
cm13_c_ossario		char(1) ,
cm13_c_campa		char(1) ,
CONSTRAINT gavetas_old_codi_pk PRIMARY KEY (cm13_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE hospitais(
cm18_i_hospital		int4 default 0,
CONSTRAINT hospitais_hosp_pk PRIMARY KEY (cm18_i_hospital));


-- M&#65533;dulo: Cemiterio
CREATE TABLE itenserv(
cm10_i_codigo		int4 default 0,
cm10_i_numpre		int4 default 0,
cm10_d_data		date default null,
cm10_i_taxaserv		int4 default 0,
cm10_f_valor		float8 default 0,
cm10_d_privenc		date default null,
cm10_i_parcelas		int4 default 0,
cm10_d_provenc		date default null,
cm10_i_diavenc		int4 default 0,
cm10_t_obs		text ,
cm10_i_usuario		int4 default 0,
CONSTRAINT itenserv_codi_pk PRIMARY KEY (cm10_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE jazigos(
cm03_i_codigo		int4 default 0,
cm03_i_proprietario		int4 default 0,
cm03_c_termo		char(10) ,
cm03_d_datatermo		date default null,
cm03_c_carta		char(10) ,
cm03_d_datacarta		date default null,
cm03_d_aquisicao		date default null,
cm03_c_base		char(10) ,
cm03_c_estrutura		char(10) ,
cm03_c_pronto		char(10) ,
cm03_c_quadra		char(3) ,
cm03_i_lote		int4 default 0,
cm03_f_metragem1		float8 default 0,
cm03_f_metragem2		float8 default 0,
CONSTRAINT jazigos_codi_pk PRIMARY KEY (cm03_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE legista(
cm32_i_codigo           int8 default 0,
cm32_i_numcgm           int4 default 0,
cm32_i_crm              int8 default 0,
CONSTRAINT legista_codi_pk PRIMARY KEY (cm32_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE lotecemit(
cm23_i_codigo		int4 default 0,
cm23_i_quadracemit		int4 default 0,
cm23_i_lotecemit		int4 default 0,
cm23_c_situacao		char(1) default 'D',
cm23_b_selecionado		bool default 'false',
CONSTRAINT lotecemit_codi_pk PRIMARY KEY (cm23_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE ossoario(
cm06_i_codigo		int4 default 0,
cm06_i_sepultamento		int4 default 0,
cm06_i_ossoario		int4 default 0,
cm06_d_entrada		date default null,
cm06_t_obs		text ,
CONSTRAINT ossoario_codi_pk PRIMARY KEY (cm06_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE ossoariojazigo(
cm25_i_codigo		int4 default 0,
cm25_i_lotecemit		int4 default 0,
cm25_f_comprimento		float4 default 0,
cm25_f_largura		float4 default 0,
cm25_c_tipo		char(1) default '0',
CONSTRAINT ossoariojazigo_codi_pk PRIMARY KEY (cm25_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE ossoariopart(
cm02_i_codigo		int4 default 0,
cm02_i_processo		int4 default 0,
cm02_i_proprietario		int4 default 0,
cm02_c_quadra		char(3) ,
cm02_i_lote		int4 default 0,
cm02_f_metragem1		float8 default 0,
cm02_f_metragem2		float8 default 0,
cm02_d_aquisicao		date default null,
cm02_d_entrada		date default null,
CONSTRAINT ossoariopart_codi_pk PRIMARY KEY (cm02_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE propricemit(
cm28_i_codigo		int4 default 0,
cm28_i_processo		int4 default 0,
cm28_i_proprietario		int4 default 0,
cm28_i_ossoariojazigo		int4 default 0,
cm28_d_aquisicao		date default null,
CONSTRAINT propricemit_codi_pk PRIMARY KEY (cm28_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE proprijazigo(
cm29_i_codigo		int4 default 0,
cm29_i_propricemit		int4 default 0,
cm29_i_termo		int4 default 0,
cm29_d_termo		date default null,
cm29_t_termo		text ,
cm29_i_concessao		int4 default 0,
cm29_d_concessao		date default null,
cm29_t_concessao		text ,
cm29_d_estrutura		date default null,
cm29_d_base		date default null,
cm29_d_pronto		date default null,
CONSTRAINT proprijazigo_codi_pk PRIMARY KEY (cm29_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE quadracemit(
cm22_i_codigo		int4 default 0,
cm22_i_cemiterio		int4 default 0,
cm22_c_quadra		char(3) ,
CONSTRAINT quadracemit_codi_pk PRIMARY KEY (cm22_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE renovacoes(
cm07_i_codigo		int4 default 0,
cm07_i_sepultamento		int4 default 0,
cm07_i_renovante		int4 default 0,
cm07_c_motivo		char(40) ,
cm07_d_ultima		date default null,
cm07_d_vencimento		date default null,
CONSTRAINT renovacoes_codi_pk PRIMARY KEY (cm07_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE restosgavetas(
cm26_i_codigo		int4 default 0,
cm26_i_sepultamento		int4 default 0,
cm26_i_ossoariojazigo		int4 default 0,
cm26_d_entrada		date default null,
CONSTRAINT restosgavetas_codi_pk PRIMARY KEY (cm26_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE restos_old(
cm12_i_codigo		int4 default 0,
cm12_i_ossoariopart		int4 default 0,
cm12_i_resto		int4 default 0,
cm12_i_sepultamento		int4 default 0,
cm12_d_entrada		date default null,
CONSTRAINT restos_old_codi_pk PRIMARY KEY (cm12_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE retiradas(
cm08_i_codigo		int4 default 0,
cm08_i_sepultamento		int4 default 0,
cm08_i_retirante		int4 default 0,
cm08_c_parentesco		char(25) ,
cm08_c_causa		char(100) ,
cm08_c_destino		char(100) ,
cm08_d_retirada		date default null,
cm08_t_obs		text ,
CONSTRAINT retiradas_codi_pk PRIMARY KEY (cm08_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE sepulta(
cm24_i_codigo		int4 default 0,
cm24_i_sepultura		int4 default 0,
cm24_i_sepultamento		int4 default 0,
cm24_d_entrada		date default null,
CONSTRAINT sepulta_codi_pk PRIMARY KEY (cm24_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE sepultamentos(
cm01_i_codigo		int4 default 0,
cm01_i_medico		int4 default 0,
cm01_i_hospital		int4 default 0,
cm01_i_funeraria		int4 default 0,
cm01_i_causa		int4 default 0,
cm01_i_funcionario		int4 default 0,
cm01_i_cemiterio		int4 default 0,
cm01_i_declarante		int4 default 0,
cm01_c_conjuge		char(40) ,
cm01_c_cor		char(1) ,
cm01_d_falecimento		date default null,
cm01_c_local		char(40) ,
cm01_c_cartorio		char(40) ,
cm01_c_livro		char(6) ,
cm01_i_folha		int4 default 0,
cm01_i_registro		int4 default 0,
cm01_d_cadastro		date default null,
cm01_c_sexo		char(1) ,
CONSTRAINT sepultamentos_codi_pk PRIMARY KEY (cm01_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE sepulthist(
cm21_i_codigo		int4 default 0,
cm21_i_sepultamento		int4 default 0,
cm21_i_usuario		int4 default 0,
cm21_d_data		date default null,
cm21_c_localnovo		char(200) ,
cm21_c_localant		char(200) ,
CONSTRAINT sepulthist_codi_pk PRIMARY KEY (cm21_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE sepulturas(
cm05_i_codigo		int4 default 0,
cm05_i_campa		int4 default 0,
cm05_i_lotecemit		int4 default 0,
CONSTRAINT sepulturas_codi_pk PRIMARY KEY (cm05_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE taxaserv(
cm11_i_codigo		int4 default 0,
cm11_c_descr		char(30) ,
cm11_f_valor		float8 default 0,
cm11_c_inflator		varchar(5) ,
cm11_i_receita		int4 default 0,
cm11_i_proced		int4 default 0,
cm11_i_historico		int4 default 0,
cm11_i_tipo		int4 default 0,
CONSTRAINT taxaserv_codi_pk PRIMARY KEY (cm11_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE txossoariojazigo(
cm30_i_codigo		int4 default 0,
cm30_i_ossoariojazigo		int4 default 0,
cm30_i_itenserv		int4 default 0,
CONSTRAINT txossoariojazigo_codi_pk PRIMARY KEY (cm30_i_codigo));


-- M&#65533;dulo: Cemiterio
CREATE TABLE txsepultamentos(
cm31_i_codigo		int4 default 0,
cm31_i_itenserv		int4 default 0,
cm31_i_sepultamento		int4 default 0,
CONSTRAINT txsepultamentos_codi_pk PRIMARY KEY (cm31_i_codigo));




-- CHAVE ESTRANGEIRA


ALTER TABLE cemiteriocgm
ADD CONSTRAINT cemiteriocgm_i_fk FOREIGN KEY (cm15_i_cemiterio)
REFERENCES cemiterio;

ALTER TABLE cemiteriocgm
ADD CONSTRAINT cemiteriocgm_i_fk FOREIGN KEY (cm15_i_cgm)
REFERENCES cgm;

ALTER TABLE cemiteriorural
ADD CONSTRAINT cemiteriorural_i_fk FOREIGN KEY (cm16_i_cemiterio)
REFERENCES cemiterio;

ALTER TABLE funerarias
ADD CONSTRAINT funerarias_i_fk FOREIGN KEY (cm17_i_funeraria)
REFERENCES cgm;

ALTER TABLE gavetas
ADD CONSTRAINT gavetas_i_fk FOREIGN KEY (cm27_i_restogaveta)
REFERENCES restosgavetas;

ALTER TABLE gavetas_old
ADD CONSTRAINT gavetas_old_i_fk FOREIGN KEY (cm13_i_jazigo)
REFERENCES jazigos;

ALTER TABLE gavetas_old
ADD CONSTRAINT gavetas_old_i_fk FOREIGN KEY (cm13_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE hospitais
ADD CONSTRAINT hospitais_i_fk FOREIGN KEY (cm18_i_hospital)
REFERENCES cgm;

ALTER TABLE itenserv
ADD CONSTRAINT itenserv_i_fk FOREIGN KEY (cm10_i_taxaserv)
REFERENCES taxaserv;

ALTER TABLE itenserv
ADD CONSTRAINT itenserv_i_fk FOREIGN KEY (cm10_i_usuario)
REFERENCES db_usuarios;

ALTER TABLE jazigos
ADD CONSTRAINT jazigos_i_fk FOREIGN KEY (cm03_i_proprietario)
REFERENCES cgm;

ALTER TABLE legista
ADD CONSTRAINT legista_i_numcgm_fk FOREIGN KEY (cm32_i_numcgm)
REFERENCES cgm;

ALTER TABLE lotecemit
ADD CONSTRAINT lotecemit_i_fk FOREIGN KEY (cm23_i_quadracemit)
REFERENCES quadracemit;

ALTER TABLE ossoario
ADD CONSTRAINT ossoario_i_fk FOREIGN KEY (cm06_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE ossoariojazigo
ADD CONSTRAINT ossoariojazigo_i_fk FOREIGN KEY (cm25_i_lotecemit)
REFERENCES lotecemit;

ALTER TABLE ossoariopart
ADD CONSTRAINT ossoariopart_i_fk FOREIGN KEY (cm02_i_processo)
REFERENCES protprocesso;

ALTER TABLE ossoariopart
ADD CONSTRAINT ossoariopart_i_fk FOREIGN KEY (cm02_i_proprietario)
REFERENCES cgm;

ALTER TABLE propricemit
ADD CONSTRAINT propricemit_i_fk FOREIGN KEY (cm28_i_processo)
REFERENCES protprocesso;

ALTER TABLE propricemit
ADD CONSTRAINT propricemit_i_fk FOREIGN KEY (cm28_i_proprietario)
REFERENCES cgm;

ALTER TABLE propricemit
ADD CONSTRAINT propricemit_i_fk FOREIGN KEY (cm28_i_ossoariojazigo)
REFERENCES ossoariojazigo;

ALTER TABLE proprijazigo
ADD CONSTRAINT proprijazigo_i_fk FOREIGN KEY (cm29_i_propricemit)
REFERENCES propricemit;

ALTER TABLE quadracemit
ADD CONSTRAINT quadracemit_i_fk FOREIGN KEY (cm22_i_cemiterio)
REFERENCES cemiterio;

ALTER TABLE renovacoes
ADD CONSTRAINT renovacoes_i_fk FOREIGN KEY (cm07_i_renovante)
REFERENCES cgm;

ALTER TABLE renovacoes
ADD CONSTRAINT renovacoes_i_fk FOREIGN KEY (cm07_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE restosgavetas
ADD CONSTRAINT restosgavetas_i_fk FOREIGN KEY (cm26_i_ossoariojazigo)
REFERENCES ossoariojazigo;

ALTER TABLE restosgavetas
ADD CONSTRAINT restosgavetas_i_fk FOREIGN KEY (cm26_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE restos_old
ADD CONSTRAINT restos_old_i_fk FOREIGN KEY (cm12_i_ossoariopart)
REFERENCES ossoariopart;

ALTER TABLE restos_old
ADD CONSTRAINT restos_old_i_fk FOREIGN KEY (cm12_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE retiradas
ADD CONSTRAINT retiradas_i_fk FOREIGN KEY (cm08_i_retirante)
REFERENCES cgm;

ALTER TABLE retiradas
ADD CONSTRAINT retiradas_i_fk FOREIGN KEY (cm08_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE sepulta
ADD CONSTRAINT sepulta_i_fk FOREIGN KEY (cm24_i_sepultura)
REFERENCES sepulturas;

ALTER TABLE sepulta
ADD CONSTRAINT sepulta_i_fk FOREIGN KEY (cm24_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_funeraria)
REFERENCES funerarias;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_funcionario)
REFERENCES db_usuarios;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_cemiterio)
REFERENCES cemiterio;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_hospital)
REFERENCES hospitais;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_causa)
REFERENCES causa;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_medico)
REFERENCES legista;

ALTER TABLE sepultamentos
ADD CONSTRAINT sepultamentos_i_fk FOREIGN KEY (cm01_i_codigo)
REFERENCES cgm;

ALTER TABLE sepulthist
ADD CONSTRAINT sepulthist_i_fk FOREIGN KEY (cm21_i_sepultamento)
REFERENCES sepultamentos;

ALTER TABLE sepulthist
ADD CONSTRAINT sepulthist_i_fk FOREIGN KEY (cm21_i_usuario)
REFERENCES db_usuarios;

ALTER TABLE sepulturas
ADD CONSTRAINT sepulturas_i_fk FOREIGN KEY (cm05_i_campa)
REFERENCES campas;

ALTER TABLE sepulturas
ADD CONSTRAINT sepulturas_i_fk FOREIGN KEY (cm05_i_lotecemit)
REFERENCES lotecemit;

ALTER TABLE taxaserv
ADD CONSTRAINT taxaserv_i_fk FOREIGN KEY (cm11_i_proced)
REFERENCES proced;

ALTER TABLE taxaserv
ADD CONSTRAINT taxaserv_i_fk FOREIGN KEY (cm11_i_historico)
REFERENCES histcalc;

ALTER TABLE taxaserv
ADD CONSTRAINT taxaserv_c_fk FOREIGN KEY (cm11_c_inflator)
REFERENCES inflan;

ALTER TABLE taxaserv
ADD CONSTRAINT taxaserv_i_fk FOREIGN KEY (cm11_i_receita)
REFERENCES tabrec;

ALTER TABLE taxaserv
ADD CONSTRAINT taxaserv_i_fk FOREIGN KEY (cm11_i_tipo)
REFERENCES arretipo;

ALTER TABLE txossoariojazigo
ADD CONSTRAINT txossoariojazigo_i_fk FOREIGN KEY (cm30_i_ossoariojazigo)
REFERENCES ossoariojazigo;

ALTER TABLE txossoariojazigo
ADD CONSTRAINT txossoariojazigo_i_fk FOREIGN KEY (cm30_i_itenserv)
REFERENCES itenserv;

ALTER TABLE txsepultamentos
ADD CONSTRAINT txsepultamentos_i_fk FOREIGN KEY (cm31_i_itenserv)
REFERENCES itenserv;

ALTER TABLE txsepultamentos
ADD CONSTRAINT txsepultamentos_i_fk FOREIGN KEY (cm31_i_sepultamento)
REFERENCES sepultamentos;




-- INDICES


CREATE UNIQUE INDEX campas_c_descr_in ON campas(cm19_c_descr);

CREATE UNIQUE INDEX causa_c_descr_in ON causa(cm04_c_descr);

CREATE UNIQUE INDEX cemiteriorural_c_nome_in ON cemiteriorural(cm16_c_nome);

CREATE  INDEX gavetas_i_restogavetas_in ON gavetas(cm27_i_restogaveta);

CREATE UNIQUE INDEX gavetas_old_i_sepultamento_in ON gavetas_old(cm13_i_sepultamento);

CREATE UNIQUE INDEX jazigo_c_quadra_i_lote_in ON jazigos(cm03_c_quadra,cm03_i_lote);

CREATE UNIQUE INDEX cem_legista_numcgm_crmcro_unique ON legista(cm32_i_numcgm, c32_crmcro);

CREATE UNIQUE INDEX lotecemit_i_quadracemit_i_lotecemit_in ON lotecemit(cm23_i_quadracemit,cm23_i_lotecemit);

CREATE UNIQUE INDEX ossoario_i_sepultamento_in ON ossoario(cm06_i_sepultamento);

CREATE UNIQUE INDEX propricemit_i_ossoariojazigo_in ON propricemit(cm28_i_ossoariojazigo);

CREATE UNIQUE INDEX proprijazigo_i_propricemit_in ON proprijazigo(cm29_i_propricemit);

CREATE  INDEX renovacoes_i_sepultamento_in ON renovacoes(cm07_i_sepultamento);

CREATE  INDEX restosgavetas_i_ossoariojazigo_in ON restosgavetas(cm26_i_ossoariojazigo);

CREATE UNIQUE INDEX restosgavetas_i_sepultultamento_in ON restosgavetas(cm26_i_sepultamento);

CREATE  INDEX restos_old_i_sepultamento_in ON restos_old(cm12_i_sepultamento);

CREATE UNIQUE INDEX retiradas_i_sepultamento_in ON retiradas(cm08_i_sepultamento);

CREATE UNIQUE INDEX sepulta_i_sepultamento_in ON sepulta(cm24_i_sepultamento);

CREATE  INDEX sepulta_d_entrada_in ON sepulta(cm24_d_entrada);

CREATE UNIQUE INDEX sepulta_i_sepultura_in ON sepulta(cm24_i_sepultura);

CREATE UNIQUE INDEX taxaserv_c_descr_in ON taxaserv(cm11_c_descr);

CREATE  INDEX txossoariojazigo_i_itenserv_in ON txossoariojazigo(cm30_i_itenserv);

CREATE  INDEX txsepultamento_i_itenserv_in ON txsepultamentos(cm31_i_itenserv);

CREATE  INDEX txsepultamento_i_sepultamento_in ON txsepultamentos(cm31_i_sepultamento);
