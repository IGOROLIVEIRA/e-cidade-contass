/**
 * ------------------------------------------------------------------------------------------
 * TIME INTEGRACAO INICIO
 * ------------------------------------------------------------------------------------------
 */

select fc_executa_ddl('                                                                                                                                                         
CREATE SCHEMA social; 
');
 
select fc_executa_ddl('
CREATE TABLE social.tiposituacaocadastrounico (
    as11_sequencial integer DEFAULT 0 NOT NULL,
    as11_situacao character varying(60)
);
');
 
select fc_executa_ddl('CREATE SEQUENCE social.tiposituacaocadastrounico_as11_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');
 
select fc_executa_ddl('ALTER TABLE social.tiposituacaocadastrounico
    ADD CONSTRAINT tiposituacaocadastrounico_sequ_pk PRIMARY KEY (as11_sequencial);
');

select fc_executa_ddl('                                                                                                                                                         
CREATE SCHEMA transporteescolar;
');
 
select fc_executa_ddl('
CREATE TABLE transporteescolar.tipotransportemunicipal (
    tre00_sequencial integer DEFAULT 0 NOT NULL,
    tre00_descricao character varying(60)
);
');
 
select fc_executa_ddl('
CREATE SEQUENCE transporteescolar.tipotransportemunicipal_tre00_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1;
');
 
select fc_executa_ddl('
ALTER TABLE transporteescolar.tipotransportemunicipal
    ADD CONSTRAINT tipotransportemunicipal_sequ_pk PRIMARY KEY (tre00_sequencial);
');

/**
 * ------------------------------------------------------------------------------------------
 * TIME INTEGRACAO FIM                                                                    
 * ------------------------------------------------------------------------------------------
 */                                                                                         
