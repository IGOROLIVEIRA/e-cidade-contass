<?php

use Phinx\Migration\AbstractMigration;

class Sigaf2 extends AbstractMigration
{
    public function up()
    {
        $sql  = "
            CREATE TABLE far_matercatmat (
            faxx_i_codigo INT PRIMARY KEY,
            faxx_i_catmat int8,
            faxx_i_desc varchar(250),
            faxx_i_ativo bool,
            faxx_i_susten bool
            );


            CREATE SEQUENCE far_matercatmat_faxx_i_codigo_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
        ";

        $this->execute($sql);
    }
}
