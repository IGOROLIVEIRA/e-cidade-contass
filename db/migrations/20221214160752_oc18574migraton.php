<?php

use Phinx\Migration\AbstractMigration;

class Oc18574migraton extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
        UPDATE db_itensmenu SET descricao='Rol de Adesão a Ata de Registro de Preço',help='Rol de Adesão a Ata de Registro de Preço',desctec='Rol de Adesão a Ata de Registro de Preço'  WHERE funcao='com2_relatorioroldeadesao.php';
        COMMIT;";

        $this->execute($sql);
    }
}
