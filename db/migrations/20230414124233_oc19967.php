<?php

use Phinx\Migration\AbstractMigration;

class Oc19967 extends AbstractMigration
{

    public function up()
    {
        $sql =  "begin;

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Lan�amento de Manuten��o','Lan�amento de Manuten��o','',1,1,'Lan�amento de Manuten��o','t');
        
        INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),16,439);
        
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclus�o','Inclus�o','pat1_lancmanutencao001.php',1,1,'Inclus�o','t');
        
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Lan�amento de Manuten��o'),(select max(id_item) from db_itensmenu),1,439);
        
        commit;";

        $this->execute($sql);
    }
}
