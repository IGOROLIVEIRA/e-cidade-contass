<?php

use Phinx\Migration\AbstractMigration;

class RelatoriosBug extends AbstractMigration
{
    public function change()
    {
        $sql = "
        begin;
            select setval('orcparamseqorcparamseqcoluna_o116_sequencial_seq',(select MAX(o116_sequencial) from orcparamseqorcparamseqcoluna));
        commit;";
        $this->execute($sql);
    }
}
