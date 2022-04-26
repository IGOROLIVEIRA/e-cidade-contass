<?php

use Phinx\Migration\AbstractMigration;

class Createtabelalicobras30202 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        DROP TABLE if exists licobras302022;

            CREATE TABLE licobras302022
            (
              si203_sequencial bigint,
              si203_tiporegistro bigint,
              si203_codorgaoresp character varying(3),
              si203_codobra bigint,
              si203_codunidadesubrespestadual character varying(4),
              si203_nroseqtermoaditivo bigint,
              si203_dataassinaturatermoaditivo date,
              si203_tipoalteracaovalor integer,
              si203_tipotermoaditivo character varying(2),
              si203_dscalteracao text,
              si203_novadatatermino date,
              si203_tipodetalhamento bigint,
              si203_valoraditivo numeric,
              si203_mes bigint,
              si203_instit integer
            )
            WITH (
              OIDS=TRUE
            );
        ";
        $this->execute($sql);
    }
}
