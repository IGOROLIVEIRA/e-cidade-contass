<?php

use Classes\PostgresMigration;

class Oc13082 extends PostgresMigration
{

    public function up()
    {
        $sql = "UPDATE db_itensmenu SET descricao = 'Anulação de Autorização de Processo de Compra' WHERE id_item = 4122";
        $this->execute($sql);
    }

    public function down() {
        $sql = "UPDATE db_itensmenu SET descricao = 'Anular autorização' WHERE id_item = 4122";
        $this->execute($sql);
    }
}
