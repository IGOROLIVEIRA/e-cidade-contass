<?php

use Phinx\Migration\AbstractMigration;

class Criatabelasicom extends AbstractMigration
{

    public function up()
    {
        $sql = "
        DROP TABLE IF EXISTS contratos132022 CASCADE;

        CREATE TABLE contratos132022 (
            si86_sequencial int8 NOT NULL DEFAULT 0,
            si86_tiporegistro int8 NOT NULL DEFAULT 0,
            si86_codcontrato int8 NOT NULL DEFAULT 0,
            si86_tipodocumento int8 NOT NULL DEFAULT 0,
            si86_nrodocumento varchar(14) NOT NULL,
            si86_tipodocrepresentante int8,
            si86_cpfrepresentantelegal varchar(11) NOT NULL,
            si86_mes int8 NOT NULL DEFAULT 0,
            si86_reg10 int8 NOT NULL DEFAULT 0,
            si86_instit int8 NULL DEFAULT 0,
            CONSTRAINT contratos132022_sequ_pk PRIMARY KEY (si86_sequencial)
        )
        WITH (
            OIDS=TRUE
        );
        CREATE INDEX contratos132022_si86_reg10_index ON contratos132022 USING btree (si86_reg10);
        
        ";
        $this->execute($sql);
    }
}
