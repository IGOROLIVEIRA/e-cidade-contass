<?php

use Phinx\Migration\AbstractMigration;

class Oc17335 extends AbstractMigration
{

    public function up()
    {
        $sql = "
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
