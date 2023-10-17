<?php

use Phinx\Migration\AbstractMigration;

class Hotfixoc21127 extends AbstractMigration
{
    public function up(){
        $sql = "
        update empenho.naturezabemservico set e101_resumo = 'Transporte de cargas, exceto os relacionados no código 8767', e101_descr = 'Transporte de cargas, exceto os relacionados no código 8767' where e101_codnaturezarendimento = 17006;
        update empenho.naturezabemservico set e101_resumo = 'Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medi...', e101_descr = 'Serviços de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatológia, medicina nuclear e análises e patologias clínicas de que trata o art. 31.' where e101_codnaturezarendimento = 17007;
        ";
        $this->execute($sql);
    }
}
