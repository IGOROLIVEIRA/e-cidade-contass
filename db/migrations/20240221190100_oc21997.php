<?php

use Phinx\Migration\AbstractMigration;

class Oc21997 extends AbstractMigration
{
    public function up()
    {
        $sSql = 
        "BEGIN;

        update obrasdadoscomplementareslote set db150_planilhatce = 2
        where db150_planilhatce is null and db150_sequencial in ((select db150_sequencial from obrasdadoscomplementareslote
        inner join obrascodigos on db151_sequencial = db150_seqobrascodigos
        inner join liclicita on db151_liclicita = l20_codigo
        where l20_anousu <= 2023));
        
        COMMIT;";

        $this->execute($sSql);
    }
}
