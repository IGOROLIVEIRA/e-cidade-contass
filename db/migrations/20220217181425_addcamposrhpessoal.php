<?php

use Phinx\Migration\AbstractMigration;

class Addcamposrhpessoal extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER TABLE rhpessoal ADD COLUMN rh01_matorgaobeneficio int8;
            ALTER TABLE rhpessoal ADD COLUMN rh01_concedido BOOLEAN;
            ALTER TABLE rhpessoal ADD COLUMN rh01_cnpjrespmatricula varchar(14);

            ALTER TABLE rhpessoalmov ADD COLUMN rh02_tipobeneficio varchar(5);
            ALTER TABLE rhpessoalmov ADD COLUMN rh02_descratobeneficio varchar(255);
        

            insert into rhtipoapos values (6,'Especial');
            insert into rhtipoapos values (7,'Sem Vinculo Previdenciario');
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        ALTER TABLE rhpessoal DROP COLUMN rh01_matorgaobeneficio;
        ALTER TABLE rhpessoal DROP COLUMN rh01_concedido;
        ALTER TABLE rhpessoal DROP COLUMN rh01_cnpjrespmatricula;

        ALTER TABLE rhpessoalmov DROP COLUMN rh02_tipobeneficio;
        ALTER TABLE rhpessoalmov DROP COLUMN rh02_descratobeneficio;

        delete from rhtipoapos where rh88_sequencial in (6,7);
    ";
        $this->execute($sql);
    }
}
