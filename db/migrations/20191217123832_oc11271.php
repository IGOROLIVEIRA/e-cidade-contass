<?php

use Phinx\Migration\AbstractMigration;

class Oc11271 extends AbstractMigration
{
    public function up()
    {
    	$sql = "
    		insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				values ((select max(id_item) from db_itensmenu) + 1, 'Envio do edital', 'Envio do edital', '', 1, 1, 'Envio do edital', 't');

				insert into db_menu(id_item, id_item_filho, menusequencia, modulo) values (1818, (select id_item from db_itensmenu where descricao = 'Envio do edital'), (select max(menusequencia) from db_menu where id_item = 1818 and modulo = 381)+1, 381);


				-- Menu Inclusão

				insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				values ((select max(id_item) from db_itensmenu) + 1, 'Inclusão', 'Inclusão do edital', 'lic4_editalabas.php', 1, 1, 'Inclusão do edital', 't');

				insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values ((select id_item from db_itensmenu where descricao = 'Envio do edital'), (select max(id_item) from db_itensmenu), 1, 381);

				-- Menu Retificação

				insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				values ((select max(id_item) from db_itensmenu) + 1, 'Retificação', 'Retificação do edital', 'lic4_editalretificacao.php', 1, 1, 'Retificação do edital', 't');

				insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values ((select id_item from db_itensmenu where descricao = 'Envio do edital'), (select max(id_item) from db_itensmenu), 2, 381);

				-- Menu Anulação/Revogação

				insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				values ((select max(id_item) from db_itensmenu) + 1, 'Anulação/Revogação', 'Anulação/Revogação do edital', 'lic4_editalanulacao.php', 1, 1, 'Anulação/Revogação do edital', 't');

				insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values ((select id_item from db_itensmenu where descricao = 'Envio do edital'), (select max(id_item) from db_itensmenu), 3, 381);
    	";
    	$this->execute($sql);
    }

    public function down(){
      $sql = "
          
      ";
    }
}
