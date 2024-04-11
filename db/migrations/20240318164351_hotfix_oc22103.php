<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc22103 extends AbstractMigration
{

    public function up()
    {
        $sql = "INSERT INTO conhistdoc
        (c53_coddoc, c53_descr, c53_tipo)
        VALUES(980, 'AJUSTE DE FONTE DE RECURSO', 3000);
        
        INSERT INTO conhist
        (c50_codhist, c50_compl, c50_descr, c50_descrcompl, c50_ativo)
        VALUES(3980, false, 'AJUSTE DE FONTE DE RECURSO', 'AJUSTE DE FONTE DE RECURSO', true);
        ";

        $this->execute($sql);
    }
}
