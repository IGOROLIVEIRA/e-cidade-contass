--sql a ser executado na base de dados

CREATE SEQUENCE farclass_fa05_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE farmatersaude_fa01_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE farparametros_fa02_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE farretirada_fa04_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE faretiradait_fa06_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE faretiradarequi_fa07_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE farequisitante_fa08_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE fartiporeceita_fa03_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;





CREATE TABLE far_class(
fa05_i_codigo		int4 default 0,
fa05_c_class		char(50) ,
fa05_c_tipo		char(2) ,
fa05_t_obs		text ,
fa05_c_descr		char(50) ,
CONSTRAINT far_class_codi_pk PRIMARY KEY (fa05_i_codigo));



CREATE TABLE far_matersaude(
fa01_i_codigo		int4 default 0,
fa01_t_obs		text ,
fa01_i_codmater		int4 default 0,
fa01_i_class		int4 default 0,
CONSTRAINT far_matersaude_codi_pk PRIMARY KEY (fa01_i_codigo));



CREATE TABLE far_parametros(
fa02_i_codigo		int4 default 0,
fa02_i_dbestrutura		int4 default 0,
fa02_c_descr		char(60) ,
fa02_c_digitacao		char(2) ,
CONSTRAINT far_parametros_codi_pk PRIMARY KEY (fa02_i_codigo));


CREATE TABLE far_retirada(
fa04_i_codigo		int4 default 0,
fa04_c_numeroreceita		char(10) ,
fa04_d_dtvalidade		date default null,
fa04_i_unidades		int4 default 0,
fa04_i_cgsund		int4 default 0,
fa04_i_tiporeceita		int4 default 0,
fa04_i_dbusuario		int4 default 0,
fa04_d_data		date default null,
fa04_i_profissional		int4 default 0,
fa04_t_posologia		text ,
CONSTRAINT far_retirada_codi_pk PRIMARY KEY (fa04_i_codigo));



CREATE TABLE far_retiradaitens(
fa06_i_codigo		int4 default 0,
fa06_t_posologia		text ,
fa06_i_retirada		int4 default 0,
fa06_i_matersaude		int4 default 0,
fa06_t_obs		text ,
fa06_f_quant		float8 default 0,
CONSTRAINT far_retiradaitens_codi_pk PRIMARY KEY (fa06_i_codigo));



CREATE TABLE far_retiradarequi(
fa07_i_codigo		int4 default 0,
fa07_i_retirada		int4 default 0,
fa07_i_matrequi		int4 default 0,
CONSTRAINT far_retiradarequi_codi_pk PRIMARY KEY (fa07_i_codigo));


CREATE TABLE far_retiradarequisitante(
fa08_i_codigo		int4 default 0,
fa08_i_cgsund		int4 default 0,
fa08_i_retirada		int4 default 0,
CONSTRAINT far_retiradarequisitante_codi_pk PRIMARY KEY (fa08_i_codigo));



CREATE TABLE far_tiporeceita(
fa03_i_codigo		int4 default 0,
fa03_c_descr		char(50) ,
fa03_c_profissional		char(2) ,
fa03_t_posologia		text ,
fa03_c_requisitante		char(50) ,
fa03_c_paciente		char(50) ,
fa03_c_numeroreceita		char(10) ,
fa03_c_quant		char(5) ,
CONSTRAINT far_tiporeceita_codi_pk PRIMARY KEY (fa03_i_codigo));






ALTER TABLE far_matersaude
ADD CONSTRAINT far_matersaude_class_fk FOREIGN KEY (fa01_i_class)
REFERENCES far_class;

ALTER TABLE far_matersaude
ADD CONSTRAINT far_matersaude_codmater_fk FOREIGN KEY (fa01_i_codmater)
REFERENCES matmater;

ALTER TABLE far_parametros
ADD CONSTRAINT far_parametros_dbestrutura_fk FOREIGN KEY (fa02_i_dbestrutura)
REFERENCES db_estrutura;

ALTER TABLE far_retirada
ADD CONSTRAINT far_retirada_tiporeceita_fk FOREIGN KEY (fa04_i_tiporeceita)
REFERENCES far_tiporeceita;

ALTER TABLE far_retirada
ADD CONSTRAINT far_retirada_dbusuario_fk FOREIGN KEY (fa04_i_dbusuario)
REFERENCES db_usuarios;

ALTER TABLE far_retirada
ADD CONSTRAINT far_retirada_cgsund_fk FOREIGN KEY (fa04_i_cgsund)
REFERENCES cgs_und;

ALTER TABLE far_retirada
ADD CONSTRAINT far_retirada_profissional_fk FOREIGN KEY (fa04_i_profissional)
REFERENCES medicos;

ALTER TABLE far_retirada
ADD CONSTRAINT far_retirada_unidades_fk FOREIGN KEY (fa04_i_unidades)
REFERENCES unidades;

ALTER TABLE far_retiradaitens
ADD CONSTRAINT far_retiradaitens_retirada_fk FOREIGN KEY (fa06_i_retirada)
REFERENCES far_retirada;

ALTER TABLE far_retiradaitens
ADD CONSTRAINT far_retiradaitens_matersaude_fk FOREIGN KEY (fa06_i_matersaude)
REFERENCES far_matersaude;

ALTER TABLE far_retiradarequi
ADD CONSTRAINT far_retiradarequi_retirada_fk FOREIGN KEY (fa07_i_retirada)
REFERENCES far_retirada;

ALTER TABLE far_retiradarequi
ADD CONSTRAINT far_retiradarequi_matrequi_fk FOREIGN KEY (fa07_i_matrequi)
REFERENCES matrequi;

ALTER TABLE far_retiradarequisitante
ADD CONSTRAINT far_retiradarequisitante_retirada_fk FOREIGN KEY (fa08_i_retirada)
REFERENCES far_retirada;

ALTER TABLE far_retiradarequisitante
ADD CONSTRAINT far_retiradarequisitante_cgsund_fk FOREIGN KEY (fa08_i_cgsund)
REFERENCES cgs_und;







CREATE UNIQUE INDEX farclass_class_in ON far_class(fa05_c_class);
CREATE SEQUENCE faretiradaitemlote_fa09_i_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE TABLE far_retiradaitemlote(
fa09_i_codigo		int4 default 0,
fa09_i_retiradaitens		int4 default 0,
fa09_i_matestoqueitem		int4 default 0,
fa09_f_quant		float4 default 0,
CONSTRAINT far_retiradaitemlote_codi_pk PRIMARY KEY (fa09_i_codigo));



ALTER TABLE far_retiradaitemlote
ADD CONSTRAINT far_retiradaitemlote_matestoqueitem_fk FOREIGN KEY (fa09_i_matestoqueitem)
REFERENCES matestoqueitem;

ALTER TABLE far_retiradaitemlote
ADD CONSTRAINT far_retiradaitemlote_retiradaitens_fk FOREIGN KEY (fa09_i_retiradaitens)
REFERENCES far_retiradaitens;

alter table far_tiporeceita add fa03_c_numeroreceita char(2);
alter table far_retirada drop fa04_t_posologia;
alter table far_retiradaitens drop fa06_t_obs;
