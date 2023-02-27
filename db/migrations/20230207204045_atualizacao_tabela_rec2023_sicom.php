<?php

use Phinx\Migration\AbstractMigration;

class AtualizacaoTabelaRec2023Sicom extends AbstractMigration
{
    public function up()
    {
        $sql = "
            ALTER TABLE rec112023 ADD COLUMN si26_codigocontroleorcamentario varchar;
            
            ALTER TABLE rec102023
            DROP COLUMN si25_regularizacaorepasse,
            DROP COLUMN si25_exercicio,
            DROP COLUMN si25_emendaparlamentar;

            ALTER TABLE arc202023
            DROP COLUMN si31_regularizacaorepasseestornada,
            DROP COLUMN si31_exercicioestornada,
            DROP COLUMN si31_emendaparlamentarestornada;
        ";
        $this->execute($sql);
    }
}
