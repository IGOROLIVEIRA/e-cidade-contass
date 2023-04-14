<?php

use Phinx\Migration\AbstractMigration;

class Oc19967 extends AbstractMigration
{

    public function up()
    {
        $sql =  "begin;

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Lançamento de Manutenção','Lançamento de Manutenção','',1,1,'Lançamento de Manutenção','t');
        
        INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),16,439);
        
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','pat1_lancmanutencao001.php',1,1,'Inclusão','t');
        
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Lançamento de Manutenção'),(select max(id_item) from db_itensmenu),1,439);
        
        commit;";

        $this->execute($sql);
    }
}
