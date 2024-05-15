<?php

use Phinx\Migration\AbstractMigration;

class Oc13889 extends AbstractMigration
{
    public function up(){
        $sql = "
                ALTER TABLE empenhosexcluidos
                ALTER COLUMN e290_z01_nome TYPE varchar(60),
                ALTER COLUMN e290_nomeusuario TYPE varchar(60)";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
                ALTER TABLE empenhosexcluidos
                ALTER COLUMN e290_z01_nome TYPE varchar(40),
                ALTER COLUMN e290_nomeusuario TYPE varchar(40)";
        $this->execute($sql);
    }
}
