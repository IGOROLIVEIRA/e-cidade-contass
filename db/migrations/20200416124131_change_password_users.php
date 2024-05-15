<?php

use Phinx\Migration\AbstractMigration;

class ChangePasswordUsers extends AbstractMigration
{
    public function up()
    {
        /** Troca de senha */
        $this->execute("update db_usuarios set senha = '3be762b7cdf2c57e1c0ecba11ae1f4f81cb97e6e' where login = 'mfmm.contass'");
        $this->execute("update db_usuarios set senha = 'ed93dc4cac453566f4c97ee512b520153e025abf' where login = 'hcgc.contass'");
        $this->execute("update db_usuarios set senha = 'a9be985526ef8dc944a3893b27cc6912823c5cf7' where login = 'mco.contass'");

        /** Ajuste de permissão*/
        $this->execute("update db_usuarios set administrador = 1 where login = 'rnss.contass'");
        $this->execute("update db_usuarios set administrador = 1 where login = 'los.contass'");
    }

    public function down()
    {

    }
}
