<?php

use Phinx\Migration\AbstractMigration;

class Oc18453 extends AbstractMigration
{

    public function up()
    {
        $sql =
            "BEGIN;

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Importar','Importar','com1_pcmaterimportacao001.php',1,1,'Importar','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Materiais/Serviços'),(select max(id_item) from db_itensmenu),4,28);
            COMMIT;";

        $this->execute($sql);
    }
}
