<?php

use Phinx\Migration\AbstractMigration;

class Oc18229 extends AbstractMigration
{

    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Solicitação de Compras (Novo)','Solicitação de Compras (Novo)','',1,1,'Solicitação de Compras (Novo)','t');        
        INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 28),28);
        
         
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','com1_solicitanovo001.php',1,1,'Inclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Solicitação de Compras (Novo)%'),(select max(id_item) from db_itensmenu),1,28);
                
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','com1_solicitanovo002.php',1,1,'Alteração','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Solicitação de Compras (Novo)%'),(select max(id_item) from db_itensmenu),2,28);
                
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','com1_solicitanovo003.php',1,1,'Exclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Solicitação de Compras (Novo)%'),(select max(id_item) from db_itensmenu),3,28);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alterar Dotações','Alterar Dotações','com4_alterardotacaosolicitacao001.php',1,1,'Alterar Dotações','t');
       

INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Solicitação de Compras (Novo)%'),(select max(id_item) from db_itensmenu),4,28);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Anulação','Anulação','com4_anularsolicitacaocompras001.php',1,1,'Anulação','t');
       

INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Solicitação de Compras (Novo)%'),(select max(id_item) from db_itensmenu),5,28);

        ";

        $this->execute($sql);
    }
}
