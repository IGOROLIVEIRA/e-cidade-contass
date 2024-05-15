<?php

use Phinx\Migration\AbstractMigration;

class Oc21090 extends AbstractMigration
{
    public function up()
    {
        $sSql = "BEGIN;
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si01_cotacaoitem','text' ,'Cotação por Item' ,'', 'Cotação por Item',22,false, false, false, 1, 'text', 'Cotação por Item');
        COMMIT;";
        $this->execute(($sSql));
    }
}
