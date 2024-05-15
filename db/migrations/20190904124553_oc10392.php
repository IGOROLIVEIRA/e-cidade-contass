<?php

use Phinx\Migration\AbstractMigration;

class Oc10392 extends AbstractMigration
{

    public function up()
    {
      $this->execute("INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Aditivos e Apostilamentos', 'Aditivos e Apostilamentos','con2_aditivosapostilamentos.php',1,1,'Relatorio de Aditivos e/ou Apostilamentos','t');");
      $this->execute("INSERT INTO db_menu VALUES (30,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where modulo = 8251), 8251);");
    }

    public function down(){

    }
}
