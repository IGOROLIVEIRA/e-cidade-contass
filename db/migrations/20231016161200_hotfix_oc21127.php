<?php

use Phinx\Migration\AbstractMigration;

class Oc21000 extends AbstractMigration
{
    public function up(){
        $sql = "
        update empenho.naturezabemservico set e101_codnaturezarendimento = 17006 where e101_resumo = 'Transporte de cargas, exceto os relacionados no c�digo 8767';
        update empenho.naturezabemservico set e101_codnaturezarendimento = 17007 where e101_resumo = 'Servi�os de aux�lio diagn�stico e terapia, patologia cl�nica, imagenologia, anatomia patol�gica e citopatol�gia, medi...';
        ";
        $this->execute($sql);
    }
}
