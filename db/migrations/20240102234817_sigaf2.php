<?php

use Phinx\Migration\AbstractMigration;

class Sigaf2 extends AbstractMigration
{
    public function up()
    {
        $sql  = "
            CREATE TABLE farmacia.far_matercatmat (
            faxx_i_codigo INT PRIMARY KEY,
            faxx_i_catmat int8,
            faxx_i_desc varchar(1000),
            faxx_i_ativo bool,
            faxx_i_susten bool
            );


            CREATE SEQUENCE farmacia.far_matercatmat_faxx_i_codigo_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Importação CATMAT', 'Importação CATMAT', 'far1_far_importacaocatmat.php', 1, 1, 'Importação CATMAT', 't');
            INSERT INTO db_menu VALUES(3444,(select max(id_item) from db_itensmenu),15,6877);

        ";

        $this->execute($sql);
    }
}
