<?php

use Phinx\Migration\AbstractMigration;

class Tabelacadobras102022 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            DROP TABLE IF EXISTS cadobras102022;

            CREATE TABLE cadobras102022
            (
            si198_sequencial bigint,
            si198_tiporegistro bigint,
            si198_codorgaoresp character varying(3),
            si198_codobra bigint,
            si198_tiporesponsavel bigint,
            si198_nrodocumento character varying(14),
            si198_tiporegistroconselho bigint,
            si198_dscoutroconselho character varying(40),
            si198_nroregistroconseprof character varying(10),
            si198_numrt bigint DEFAULT 0,
            si198_dtinicioatividadeseng date,
            si198_tipovinculo bigint,
            si198_mes bigint,
            si198_instit integer
            )
            WITH (
            OIDS=TRUE
            );
            ALTER TABLE cadobras102022
            OWNER TO dbportal;
        ";
        $this->execute($sql);
    }
}
