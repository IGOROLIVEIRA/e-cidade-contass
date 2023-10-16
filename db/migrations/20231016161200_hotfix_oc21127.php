<?php

use Phinx\Migration\AbstractMigration;

class Oc21000 extends AbstractMigration
{
    public function up(){
        $sql = "
        update empenho.naturezabemservico set e101_codnaturezarendimento = 17006 where e101_resumo = 'Transporte de cargas, exceto os relacionados no código 8767';
        update empenho.naturezabemservico set e101_codnaturezarendimento = 17007 where e101_resumo = 'Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medi...';
        ";
        $this->execute($sql);
    }
}
