<?php

use Phinx\Migration\AbstractMigration;

class Oc22209 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            begin;
            update db_itensmenu set descricao = 'Anexar Documentos no PNCP'
            where funcao = 'con4_anexarArquivos001.php';
            commit;
        ";
        $this->execute($sql);
    }
}
