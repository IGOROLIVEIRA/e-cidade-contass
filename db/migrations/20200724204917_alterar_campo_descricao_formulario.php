<?php

use Classes\PostgresMigration;

class AlterarCampoDescricaoFormulario extends PostgresMigration
{
    public function up()
    {
        $sSql  = "UPDATE db_syscampo SET tamanho = 100  WHERE nomecam = 'db101_descricao'";
        $this->execute($sSql);
    }

    public function down()
    {
        $sSql  = "UPDATE db_syscampo SET tamanho = 50  WHERE nomecam = 'db101_descricao'";
        $this->execute($sSql);
    }
    
}
