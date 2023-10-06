<?php


use Phinx\Migration\AbstractMigration;

class Ardigital003 extends AbstractMigration
{
    public function up()
    {
        $this->execute("
                    UPDATE
                    CONFIGURACOES.DB_LAYOUTCAMPOS
                    SET DB52_TAMANHO = 13,
                        DB52_DEFAULT = '0000000000000'
                    WHERE DB52_LAYOUTLINHA =
                            (SELECT DB51_CODIGO
                                FROM DB_LAYOUTLINHA
                                WHERE DB51_LAYOUTTXT = 26)
                        AND DB52_NOME = 'numero_etiqueta'
        ");
    }
}
