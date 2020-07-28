<?php

use Phinx\Migration\AbstractMigration;

class Oc12849 extends AbstractMigration
{
    public function up(){
		$sql = "
				CREATE TABLE historicocgm(
					z09_sequencial integer NOT NULL,
					z09_numcgm INTEGER NOT NULL,
					z09_usuario INTEGER NOT NULL,
					z09_datacadastro DATE,
					z09_dataservidor DATE NOT NULL DEFAULT CURRENT_DATE,
					z09_motivo TEXT,
					PRIMARY KEY(z09_sequencial)
				);
								
				CREATE SEQUENCE historicocgm_z09_sequencial_seq
					START WITH 1 
					INCREMENT BY 1 
					NO MINVALUE 
					NO MAXVALUE 
					CACHE 1;
				
				ALTER TABLE ONLY historicocgm
					ADD CONSTRAINT historicocgm_fk FOREIGN KEY (z09_numcgm) REFERENCES cgm(z01_numcgm);
					
				-- Cria Menu para Alteração de Data de Cadastro
				
				INSERT INTO db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				  VALUES ((SELECT max(id_item) FROM db_itensmenu) + 1, 'Alteração de Data de Cadastro', 'Alteração de Data de Cadastro', 'prot1_alteradatacadcgm.php', 1, 1, 'Alteração de Data de Cadastro', 't');
				
				INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo)
					VALUES (8451, (SELECT id_item FROM db_itensmenu WHERE descricao = 'Alteração de Data de Cadastro' LIMIT 1),
							  (SELECT max(menusequencia) FROM db_menu WHERE id_item = 8451 AND modulo = 604)+1, 604);					
		";
		$this->execute($sql);
    }

    public function down(){
		$sql = "
			DROP SEQUENCE historicocgm_z09_sequencial_seq;

			DROP TABLE historicocgm;
			
			DELETE FROM db_menu where id_item_filho = (SELECT id_item
             	FROM db_itensmenu
             	WHERE descricao = 'Alteração de Data de Cadastro' LIMIT 1);

			DELETE FROM db_itensmenu where descricao = 'Alteração de Data de Cadastro';
		";
		$this->execute($sql);
	}
}
