<?php

use Phinx\Migration\AbstractMigration;

class Cadobras2024 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            -- Drop table
                DROP TABLE public.cadobras102024;

                CREATE TABLE public.cadobras102024 (
                    si198_sequencial int8 NULL,
                    si198_tiporegistro int8 NULL,
                    si198_codorgaoresp varchar(3) NULL,
                    si198_codobra int8 NULL,
                    si198_tiporesponsavel int8 NULL,
                    si198_tipodocumento int8 NULL,
                    si198_nrodocumento varchar(14) NULL,
                    si198_tiporegistroconselho int8 NULL,
                    si198_dscoutroconselho varchar(40) NULL,
                    si198_nroregistroconseprof varchar(10) NULL,
                    si198_numrt int8 NULL DEFAULT 0,
                    si198_dtinicioatividadeseng date NULL,
                    si198_tipovinculo int8 NULL,
                    si198_mes int8 NULL,
                    si198_instit int4 NULL
                );
        ";

        $this->execute($sql);
    }
}
