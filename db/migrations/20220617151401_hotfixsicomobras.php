<?php

use Phinx\Migration\AbstractMigration;

class Hotfixsicomobras extends AbstractMigration
{

    public function up()
    {
        $sql = "

            BEGIN;
                DROP TABLE exeobras102022;

                CREATE TABLE exeobras102022 (
                    si197_sequencial int8 NULL,
                    si197_tiporegistro int8 NULL,
                    si197_codorgao varchar(3) NULL,
                    si197_codunidadesub varchar(8) NULL,
                    si197_nrocontrato int8 NULL,
                    si197_exerciciocontrato int8 null,
                    si197_contdeclicitacao int8 null,
                    si197_exerciciolicitacao int8 NULL,
                    si197_nroprocessolicitatorio int8 null,
                    si197_codunidadesubresp int8 null,
                    si197_nrolote int8 null,
                    si197_codobra int8 NULL,
                    si197_objeto text NULL,
                    si197_linkobra text NULL,
                    si197_mes int8 NULL,
                    si197_instit int4 NULL
                );

            COMMIT;
        ";
        $this->execute($sql);
    }
}
