<?php

use Phinx\Migration\AbstractMigration;

class Addmenunperiodicos extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'N�o Periodicos','Carga de dados N�o Periodicos','con4_cargaformularioseventosnaoperiodicos.php',1,1,'N�o Periodicos','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao = 'Carga de Dados'),(select max(id_item) from db_itensmenu),2,10216);
        COMMIT;
        ";
        $this->execute($sql);
    }
}
