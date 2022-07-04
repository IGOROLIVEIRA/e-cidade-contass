<?php

use Phinx\Migration\AbstractMigration;

class Oc17746 extends AbstractMigration
{

    public function up()
    {
        $sql = "ALTER TABLE acordo ADD ac16_datareferencia date null;
                ALTER TABLE apostilamento ADD si03_datareferencia date null;
                ALTER TABLE acordoposicaoaditamento ADD ac35_datareferencia date null;
                ALTER TABLE acordo ADD ac16_datareferenciarescisao date null;
                UPDATE acordo SET ac16_datareferencia =  ac16_dataassinatura;
                update apostilamento set si03_datareferencia = si03_dataapostila;
                update acordoposicaoaditamento set ac35_datareferencia = ac35_dataassinaturatermoaditivo;
                update acordo set ac16_datareferenciarescisao = ac16_datarescisao;";
        $this->execute($sql);
    }
}
