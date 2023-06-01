<?php

use Phinx\Migration\AbstractMigration;

class Oc19719 extends AbstractMigration
{

    public function up()
    {
        $sql = "BEGIN;

        ALTER TABLE materialestoquegrupoconta
        ADD m66_codconcredito int4 null;
        
        ALTER TABLE materialestoquegrupoconta
        ADD m66_codcondebito int4 null;
        
        ALTER TABLE materialestoquegrupoconta
        ADD FOREIGN KEY (m66_codconcredito,m66_anousu)  REFERENCES contabilidade.conplano(c60_codcon,c60_anousu);
        
        ALTER TABLE materialestoquegrupoconta
        ADD FOREIGN KEY (m66_codcondebito,m66_anousu)  REFERENCES contabilidade.conplano(c60_codcon,c60_anousu);
        
        COMMIT;";

        $this->execute($sql);
    }
}
