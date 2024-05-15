<?php

use Phinx\Migration\AbstractMigration;

class Oc16226 extends AbstractMigration
{

    public function up()
    {
        $sql = "insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','con4_adesaoitensregprecos001.php',1,1,'Inclusão','t');
        insert into db_menu values ((select id_item from db_itensmenu where descricao = 'Adesão de registro de preço'),(select max(id_item) from db_itensmenu),1,28);
        
        insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','con4_adesaoitensregprecos002.php',1,1,'Alteração','t');
        insert into db_menu values ((select id_item from db_itensmenu where descricao = 'Adesão de registro de preço'),(select max(id_item) from db_itensmenu),2,28);
        
        insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','con4_adesaoitensregprecos003.php',1,1,'Exclusão','t');
        insert into db_menu values ((select id_item from db_itensmenu where descricao = 'Adesão de registro de preço'),(select max(id_item) from db_itensmenu),3,28);";

        $this->execute($sql);
    }
}
