<?php

use Phinx\Migration\AbstractMigration;

class MenuImportarJulgamentoOc20204 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Importar Julgamento','Importar Julgamento','lic1_importajulgamento001.php',1,1,'Importar Julgamento','t');
            INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),5,381);

        COMMIT;
        ";

        $this->execute($sql);
    }
}
