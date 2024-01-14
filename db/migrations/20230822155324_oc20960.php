<?php

use Phinx\Migration\AbstractMigration;

class Oc20960 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            CREATE TABLE historicomaterial(
                            db150_sequencial         int8,
                            db150_tiporegistro       int8,
                            db150_coditem            int8,
                            db150_pcmater            int8,
                            db150_dscitem            text,
                            db150_unidademedida      varchar(50),
                            db150_tipocadastro       int8,
                            db150_justificativaalteracao varchar(100),
                            db150_mes                int4,
                            db150_data               date,
                            db150_instit             int4);

            ALTER TABLE historicomaterial ADD PRIMARY KEY (db150_sequencial);

            CREATE SEQUENCE historicomaterial_db150_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

        ";
        $this->execute($sql);
    }
}
