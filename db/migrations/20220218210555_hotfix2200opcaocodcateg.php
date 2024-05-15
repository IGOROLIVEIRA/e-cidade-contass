<?php

use Phinx\Migration\AbstractMigration;

class Hotfix2200opcaocodcateg extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
        INSERT INTO habitacao.avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_aceitatexto, db104_identificador, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES((select max(db104_sequencial)+1 from avaliacaoperguntaopcao), 4000632, '', true, 'codCateg-12', 0, '', 'codCateg');
        COMMIT;
        ";
        $this->execute($sql);
    }
}
