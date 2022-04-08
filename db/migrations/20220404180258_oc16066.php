<?php

use Phinx\Migration\AbstractMigration;

class Oc16066 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "
            update db_itensmenu set descricao = 'Registro de preço' where funcao = 'com4_consabertregistro001.php';
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
            update db_itensmenu set descricao = 'Abertura de Registro de preço' where funcao = 'com4_consabertregistro001.php';
        ";
        $this->execute($sql);
    }
}
