<?php

use Phinx\Migration\AbstractMigration;

class Oc15187 extends AbstractMigration
{
    public function up()
    {
        
        $this->execute("INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Importação', 'Importação', ' ', 1, 1, 'Importação Abastecimento', 't')");
        $this->execute("INSERT INTO db_menu VALUES(5338,(select max(id_item) from db_itensmenu),9,633)");

        $this->execute("INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Abastecimento','Abastecimento','vei1_abastimportacao001.php',1,1,'Abastecimento','t')");
        $this->execute("INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%Importação Abastecimento'),(select max(id_item) from db_itensmenu),1,633)");

        $this->execute("ALTER TABLE veicabast ADD column ve70_importado bool");
        $this->execute("ALTER TABLE veicdevolucao ADD column ve61_importado bool");
        $this->execute("ALTER TABLE veicretirada ADD column ve60_importado bool");

       
    }
   
}
