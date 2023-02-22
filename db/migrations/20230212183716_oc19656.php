<?php

use Phinx\Migration\AbstractMigration;

class Oc19656 extends AbstractMigration
{
    public function up()
    {
        $sql = "
                ALTER TABLE empenho.empempenho
                ADD COLUMN e60_emendaparlamentar int8 DEFAULT NULL,
                ADD COLUMN e60_esferaemendaparlamentar int8 DEFAULT NULL;
                ALTER TABLE emp102023 DROP COLUMN si106_tipodespesaemprpps;
                ALTER TABLE emp112023 ADD COLUMN si107_codco varchar(4) DEFAULT 0;
                ALTER TABLE anl112023 ADD COLUMN si111_codco varchar(4) DEFAULT NULL;
        ";
        
        $this->execute($sql);
    }
}
