<?php

use Phinx\Migration\AbstractMigration;

class RemoverRespostasEsocial extends AbstractMigration
{

    public function up()
    {
        $sql = "
        DELETE FROM avaliacaogrupoperguntaresposta;
        DELETE FROM avaliacaogruporesposta;
        DELETE FROM avaliacaoresposta;
        ";

        $this->execute($sql);
    }
}
