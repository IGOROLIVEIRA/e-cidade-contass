<?php

use Phinx\Migration\AbstractMigration;

class Oc13009 extends AbstractMigration
{
    public function up(){
    	$sql = "
    		UPDATE db_itensmenu SET descricao = 'Inclus�o', help = 'Inclus�o' WHERE funcao = 'lic1_liclicitaoutrosorgaos001.php'; 
			UPDATE db_itensmenu SET descricao = 'Altera��o', help = 'Altera��o' WHERE funcao = 'lic1_liclicitaoutrosorgaos002.php'; 
    	";

		$this->execute($sql);

    }

    public function down(){
		$sql = "
    		UPDATE db_itensmenu SET descricao = 'Inclusao', help = 'Inclusao' WHERE funcao = 'lic1_liclicitaoutrosorgaos001.php'; 
			UPDATE db_itensmenu SET descricao = 'Alteracao', help = 'Alteracao' WHERE funcao = 'lic1_liclicitaoutrosorgaos002.php'; 
    	";

		$this->execute($sql);
	}
}
