<?php

use Phinx\Migration\AbstractMigration;

class Oc18574 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Rol de Ades�o a Ata de Registro de Pre�o','Rol de Ades�o a Ata de Registro de Pre�o','com2_relatorioroldeadesao.php',1,1,'Rol de Ades�o a Ata de Registro de Pre�o','t');
        INSERT INTO db_menu VALUES(30,(select max(id_item) from db_itensmenu),431,28);
        COMMIT;";

        $this->execute($sql);
    }
}
