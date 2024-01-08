<?php

use Phinx\Migration\AbstractMigration;

class SicomEdital2024 extends AbstractMigration
{

    public function up()
    {
        $sql = "
                ALTER TABLE ralic102024
                ALTER COLUMN si180_emailcontato TYPE INTEGER USING si180_emailcontato::INTEGER;

                alter table ralic102024 add column si180_emailcontato varchar(200);

                alter table ralic112024 add column si181_utilizacaoplanilhamodelo int8;

                CREATE SEQUENCE ideedital2024_si186_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                CREATE SEQUENCE ralic102024_si180_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                CREATE SEQUENCE ralic112024_si181_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;



                CREATE SEQUENCE ralic122024_si182_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                ALTER TABLE redispi102024 add column si183_emailcontato varchar(200);

                ALTER TABLE redispi112024 add column si184_utilizacaoplanilhamodelo int8;

                CREATE SEQUENCE redispi102024_si183_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                CREATE SEQUENCE redispi112024_si184_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;


                CREATE SEQUENCE redispi122024_si185_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

        ";

        $this->execute($sql);
    }
}
