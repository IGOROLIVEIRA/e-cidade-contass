<?php

use Phinx\Migration\AbstractMigration;

class AtualizacaoRubricas extends AbstractMigration
{

    public function change()
    {
        $sql = "UPDATE avaliacaopergunta SET db103_obrigatoria = 't' WHERE db103_sequencial = 3000941";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "UPDATE avaliacaopergunta SET db103_obrigatoria = 'f' WHERE db103_sequencial = 3000941";
        $this->execute($sql);
    }
}
