<?php

use Phinx\Migration\AbstractMigration;

class Oc17504 extends AbstractMigration
{

    public function up()
    {
        $sql = "
                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Adesão de Registro de Preço','Adesão de Registro de Preço','m5_adesaoregpreco.php',1,1,'Adesão de Registro de Preço','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%amentos (Patrimonial)%'),(select max(id_item) from db_itensmenu),6,1);

                ALTER TABLE adesaoregprecos ADD COLUMN si06_departamento int8;
                ALTER TABLE adesaoregprecos ADD COLUMN si06_codunidadesubant varchar(8);";
        $this->execute($sql);
    }
}
