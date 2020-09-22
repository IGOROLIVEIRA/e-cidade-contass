<?php

use Phinx\Migration\AbstractMigration;

class Oc12770 extends AbstractMigration
{
    public function up(){
		$sql = "
				
				CREATE TABLE editalsituacao(
					l10_sequencial INTEGER NOT NULL,
					l10_descr varchar(20),
					PRIMARY KEY(l10_sequencial)
				);
						
				INSERT INTO editalsituacao(l10_sequencial, l10_descr)
						VALUES (0, 'SEM EDITAL'),
							   (1, 'PENDENTE'),
							   (2, 'AGUARDANDO ENVIO'),
							   (3, 'ENVIADO');
			
				UPDATE liclicita SET l20_cadinicial = 0 WHERE l20_cadinicial IS NULL;
				
				ALTER TABLE liclancedital ADD COLUMN l47_dataenviosicom DATE DEFAULT NULL;
						
				ALTER TABLE liclicita ADD CONSTRAINT liclicita_editalsituacao_fk
					FOREIGN KEY (l20_cadinicial) REFERENCES editalsituacao (l10_sequencial) MATCH FULL;
		";
		$this->execute($sql);
    }

    public function down(){
    	$sql = "
				UPDATE liclicita set l20_cadinicial = NULL where l20_cadinicial = 0;
				ALTER TABLE liclancedital DROP COLUMN l47_dataenviosicom;
				ALTER TABLE liclicita DROP CONSTRAINT liclicita_editalsituacao_fk;
				DROP TABLE editalsituacao;    	
    	";

    	$this->execute($sql);
	}
}
