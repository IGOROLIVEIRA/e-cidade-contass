<?php

use Phinx\Migration\AbstractMigration;

class Controleanexos extends AbstractMigration
{
    public function up()
    {
        $sql = "
            DROP TABLE IF EXISTS acoanexopncp;

            CREATE TABLE public.acoanexopncp (
                ac214_sequencial int8 NOT NULL,
                ac214_acordo int8 NULL,
                ac214_usuario int8 NOT NULL,
                ac214_dtlancamento date NOT NULL,
                ac214_numerocontrolepncp text NOT NULL,
                ac214_tipoanexo varchar(30) NOT NULL,
                ac214_instit int8 NOT NULL,
                ac214_ano int8 NOT NULL,
                ac214_sequencialpncp int8 NOT NULL,
                ac214_sequencialarquivo int8 NOT NULL,
                CONSTRAINT acoanexopncp_sequ_pk PRIMARY KEY (ac214_sequencial)
            );

            CREATE SEQUENCE acoanexopncp_ac214_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

        ";
        $this->execute($sql);
    }
}
