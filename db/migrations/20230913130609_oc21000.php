<?php

use Phinx\Migration\AbstractMigration;

class Oc21000 extends AbstractMigration
{
    
    public function up()
    {
        $this->criaMenu();
    }

    public function down()
    {
        $this->restauraMenu();
    }

    public function criaMenu(){
        $sql = "INSERT INTO configuracoes.db_itensmenu
        (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
        VALUES((select max(id_item)+1 FROM db_itensmenu), 'Anexo III - Dem.da Rec. Corrente Líquida (novo)', 'Anexo III - Dem.da Rec. Corrente Líquida (novo)', 'con2_lrfreceitacorrente001_novo.php', 1, '1', 'Anexo III', true);
        
        UPDATE configuracoes.db_menu SET menusequencia = (select max(menusequencia)+1 FROM db_menu WHERE id_item = (select id_item FROM db_itensmenu WHERE help = 'RREO 2018')) WHERE id_item = (select id_item FROM db_itensmenu WHERE help = 'RREO 2018') and menusequencia = 4;
        
        INSERT INTO configuracoes.db_menu
        (id_item, id_item_filho, menusequencia, modulo)
        VALUES((select id_item FROM db_itensmenu WHERE help = 'RREO 2018'), (select id_item FROM db_itensmenu WHERE help = 'Anexo III - Dem.da Rec. Corrente Líquida (novo)'), 4, 209);
        ";

        $this->execute($sql);
    }

    public function restauraMenu(){
        $sql = "DELETE FROM configuracoes.db_menu WHERE id_item_filho = (select id_item FROM configuracoes.db_itensmenu WHERE descricao = 'Anexo III - Dem.da Rec. Corrente Líquida (novo)');

        DELETE FROM configuracoes.db_itensmenu WHERE descricao = 'Anexo III - Dem.da Rec. Corrente Líquida (novo)';
        
        UPDATE configuracoes.db_menu SET menusequencia = 4 WHERE id_item_filho = (select db_itensmenu.id_item FROM db_itensmenu join db_menu on db_menu.id_item_filho = db_itensmenu.id_item WHERE descricao = 'Anexo III - Dem.da Rec. Corrente Líquida' and db_menu.id_item = (select id_item FROM db_itensmenu WHERE help = 'RREO 2018'));";
    
    $this->execute($sql);
    }
}
