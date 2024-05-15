<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc11422 extends PostgresMigration
{
    public function up()
    {
        $sql = "UPDATE db_layoutcampos SET db52_nome='data_laudo',db52_tamanho = 8,db52_descr = 'DATA LAUDO' WHERE db52_codigo = 1010756";
        $this->execute($sql);

        $sql = "UPDATE db_layoutlinha SET db51_compacta = 't' WHERE db51_codigo = 636";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "UPDATE db_layoutcampos SET db52_nome='branco',db52_tamanho = 0,db52_descr = 'BRANCO' WHERE db52_codigo = 1010756";
        $this->execute($sql);

        $sql = "UPDATE db_layoutlinha SET db51_compacta = 'f' WHERE db51_codigo = 636";
        $this->execute($sql);
    }
}
