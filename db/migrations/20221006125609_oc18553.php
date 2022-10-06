<?php

use Phinx\Migration\AbstractMigration;

class Oc18553 extends AbstractMigration
{

    public function up()
    {
        $sql = "

        BEGIN;

        CREATE SEQUENCE amparolegal_l212_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

create table amparolegal(

 l212_codigo int not null default 0,
 l212_lei varchar (100) not null ,
 CONSTRAINT amparolegal_sequ_pk PRIMARY KEY (l212_codigo));

        COMMIT;

        ";
    }
}
