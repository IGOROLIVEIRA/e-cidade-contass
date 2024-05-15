<?php

use Phinx\Migration\AbstractMigration;

class Oc18574 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Rol de Adesão a Ata de Registro de Preço','Rol de Adesão a Ata de Registro de Preço','com2_relatorioroldeadesao.php',1,1,'Rol de Adesão a Ata de Registro de Preço','t');
        INSERT INTO db_menu VALUES(30,(select max(id_item) from db_itensmenu),431,28);
        COMMIT;";

        $this->execute($sql);
    }
}
