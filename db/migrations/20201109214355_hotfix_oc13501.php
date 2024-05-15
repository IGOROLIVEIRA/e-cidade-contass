<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc13501 extends AbstractMigration
{
    public function up(){
		$sSql = "
				UPDATE db_itensmenu
				SET descricao = 'Cadastro de Edital',
    				help = 'Cadastro de Edital',
    				desctec = 'Cadastro de Edital'
				WHERE id_item = (select id_item from db_itensmenu where descricao = 'Envio de Edital');
		";
		$this->execute($sSql);
    }

    public function down(){
		$sql = "
			UPDATE db_itensmenu
				SET descricao = 'Envio de Edital',
    				help = 'Envio de Edital',
    				desctec = 'Envio de Edital'
				WHERE id_item = (select id_item from db_itensmenu where descricao = 'Cadastro de Edital');
		";
		$this->execute($sql);
	}
}
