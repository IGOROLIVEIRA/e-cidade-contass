<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc13082 extends PostgresMigration
{

    public function up()
    {
        $sql = "UPDATE db_itensmenu SET descricao = 'Anula��o de Autoriza��o de Processo de Compra' WHERE id_item = 4122";
        $this->execute($sql);
    }

    public function down() {
        $sql = "UPDATE db_itensmenu SET descricao = 'Anular autoriza��o' WHERE id_item = 4122";
        $this->execute($sql);
    }
}
