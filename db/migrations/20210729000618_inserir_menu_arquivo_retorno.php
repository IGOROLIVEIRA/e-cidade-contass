<?php

use Phinx\Migration\AbstractMigration;

class InserirMenuArquivoRetorno extends AbstractMigration
{
    
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Arquivo Retorno', 'Arquivo Retorno','pes4_arquivoretorno001.php',1,1,'','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao='E-social'),(SELECT max(id_item) FROM db_itensmenu),(SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao='E-social') AND modulo = 952),952);
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao='Arquivo Retorno');
        DELETE FROM db_itensmenu WHERE descricao='Arquivo Retorno';
        ";
        
        $this->execute($sql);
    }
}
