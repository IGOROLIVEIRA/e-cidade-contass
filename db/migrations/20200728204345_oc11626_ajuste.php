<?php

use Phinx\Migration\AbstractMigration;

class Oc11626Ajuste extends AbstractMigration
{
    public function change()
    {
        $sql = "
            update orcparamseq set o69_descr = 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS INDIVIDUAIS', o69_labelrel = 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS INDIVIDUAIS' where o69_codparamrel = 166 and o69_codseq = 15;

            update orcparamseq set o69_descr = 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS DE BANCADA', o69_labelrel = 'TRANSFERÊNCIAS OBRIGATÓRIAS EMENDAS DE BANCADA' where o69_codparamrel = 166 and o69_codseq = 16;
        ";
        $this->execute($sql);
    }
}
