<?php

use Phinx\Migration\AbstractMigration;

class Hotfixchagetypeinstituicaos2200 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE habitacao.avaliacaopergunta
            SET db103_avaliacaotiporesposta=2
            WHERE db103_sequencial=4001581;
        ";
        $this->execute($sql);
    }
}
