<?php

use Phinx\Migration\AbstractMigration;

class Oc16386 extends AbstractMigration
{
    
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        
            alter table aberlic102022 add column si46_leidalicitacao int;

            alter table aberlic102022 add column si46_dtpulicacaopncp date;

            alter table aberlic102022 add column si46_linkpncp varchar(255);

            alter table aberlic102022 add column si46_dtpulicacaoedital date;

            alter table aberlic102022 add column si46_linkedital varchar(255);

            alter table aberlic102022 add column si46_diariooficialdivulgacao int;

            alter table aberlic102022 add column si46_mododisputa int;

            alter table dispensa102022 add column si74_leidalicitacao int;

            alter table regadesao102022 add column si67_leidalicitacao int;
                    
        COMMIT;

SQL;
    $this->execute($sql);
  }
}
