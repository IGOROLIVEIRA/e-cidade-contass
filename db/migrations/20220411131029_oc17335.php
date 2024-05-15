<?php

use Phinx\Migration\AbstractMigration;

class Oc17335 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            DROP TABLE if exists licobras102022;

            CREATE TABLE licobras102022 (
                si195_sequencial int8 NULL,
                si195_tiporegistro int8 NULL,
                si195_codorgaoresp varchar(3) NULL,
                si195_codunidadesubrespestadual varchar(4) NULL,
                si195_exerciciolicitacao int8 NULL,
                si195_nroprocessolicitatorio varchar(12) NULL,
                si195_nrolote int8 NULL,
                si195_contdeclicitacao int8 NULL,
                si195_codobra int8 NULL,
                si195_objeto text NULL,
                si195_linkobra text NULL,
                si195_codorgaorespsicom int8 NULL,
                si195_codunidadesubsicom int8 NULL,
                si195_nrocontrato int8 NULL,           
                si195_exerciciocontrato int8 NULL,     
                si195_dataassinatura date,
                si195_vlcontrato numeric,        
                si195_undmedidaprazoexecucao int8 NULL,
                si195_prazoexecucao int8 NULL,
                si195_mes int8 NULL,
                si195_instit int4 NULL
            )
            WITH (
                OIDS=TRUE
            );
            
            DROP TABLE if exists licobras202022;
            
            CREATE TABLE licobras202022 (
                si196_sequencial int8 NULL,
                si196_tiporegistro int8 NULL,
                si196_codorgaoresp varchar(3) NULL,
                si196_codunidadesubrespestadual varchar(4) NULL,
                si196_exerciciolicitacao int8 NULL,
                si196_nroprocessolicitatorio varchar(12) NULL,
                si196_tipoprocesso int4 NULL,
                si196_contdeclicitacao int8 NULL,
                si196_codobra int8 NULL,
                si196_objeto text NULL,
                si196_linkobra text NULL,
                si196_codorgaorespsicom int8 NULL,
                si196_codunidadesubsicom int8 NULL,
                si196_nrocontrato int8 NULL,           
                si196_exerciciocontrato int8 NULL,   
                si196_dataassinatura date,
                si196_vlcontrato numeric,           
                si196_undmedidaprazoexecucao int8 NULL,
                si196_prazoexecucao int8 NULL,        
                si196_mes int8 NULL,
                si196_instit int4 NULL
            )
            WITH (
                OIDS=TRUE
            );
            
            DROP TABLE if exists exeobras202022;
            
            CREATE TABLE exeobras202022
            (
            si204_sequencial bigint,
            si204_tiporegistro bigint,
            si204_codorgao character varying(3),
            si204_codunidadesub character varying(8),
            si204_nrocontrato bigint,
            si204_exerciciocontrato bigint,
            si204_contdeclicitacao bigint,
            si204_exercicioprocesso bigint,
            si204_nroprocesso character varying(12),
            si204_codunidadesubresp character varying(8),
            si204_tipoprocesso bigint,
            si204_codobra bigint,
            si204_objeto text,
            si204_linkobra text,
            si204_mes bigint,
            si204_instit integer
            )
            WITH (
            OIDS=TRUE
            );
            ALTER TABLE exeobras202022
            OWNER TO dbportal;
            
            CREATE SEQUENCE exeobras202022_si204_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
        ";
        $this->execute($sql);
    }
}
