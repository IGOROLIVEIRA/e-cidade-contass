<?php

use Phinx\Migration\AbstractMigration;

class Oc21069 extends AbstractMigration
{
    public function up()
    {
        $sql = "alter table pcproc add column pc80_modalidadecontratacao int4;

                UPDATE db_itensmenu
                SET descricao='Contratação Direta - Sem concorrência'
                WHERE id_item IN
                        (SELECT id_item
                         FROM db_itensmenu
                         WHERE funcao = 'com1_pncpdispensaporvalor001.php' );";

        $this->execute($sql);
    }
}
