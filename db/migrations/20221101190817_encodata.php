<?php

use Phinx\Migration\AbstractMigration;

class Encodata extends AbstractMigration
{

    public function up()
    {
        $sql = "BEGIN;

        UPDATE db_itensmenu SET descricao = 'Ata de Registro de Preço', help = 'Ata de Registro de Preço', desctec = 'Ata de Registro de Preço' WHERE id_item in (select id_item from db_itensmenu WHERE descricao like '%Ata de Registro de Pre%');

        UPDATE db_itensmenu SET descricao = 'Inclusão', help = 'Inclusão', desctec = 'Inclusão', funcao = 'lic1_licataregaba001.php' WHERE funcao = 'lic1_licatareg002.php' AND descricao like '%Inclus%';

        UPDATE db_itensmenu SET descricao = 'Alteração', help = 'Alteração', desctec = 'Alteração', funcao = 'lic1_licataregaba002.php' WHERE funcao = 'lic1_licatareg002.php' AND descricao like '%Altera%';

        UPDATE db_itensmenu SET descricao = 'Exclusão', help = 'Exclusão', desctec = 'Exclusão', funcao = 'lic1_licatareg003.php' WHERE funcao = 'lic1_licatareg002.php' AND descricao like '%Exclus%';

        DELETE FROM db_menu WHERE id_item_filho in (select max(id_item) FROM db_itensmenu WHERE descricao like '%Gerar Autoriz%' AND funcao = 'lic1_licatareg002.php');
        DELETE FROM db_itensmenu WHERE descricao like '%Gerar Autoriz%' and funcao = 'lic1_licatareg002.php';

        DELETE FROM db_menu WHERE id_item_filho in (select max(id_item) FROM db_itensmenu WHERE descricao like '%Reequil%' AND funcao = 'lic1_licatareg002.php');
        DELETE FROM db_itensmenu WHERE descricao like '%Reequil%' AND funcao = 'lic1_licatareg002.php';

        DELETE FROM db_menu WHERE id_item_filho in (select max(id_item) FROM db_itensmenu WHERE descricao like '%Desist%' AND funcao = 'lic1_licatareg002.php');
        DELETE FROM db_itensmenu WHERE descricao like '%Desist%' AND funcao = 'lic1_licatareg002.php';
        
        UPDATE db_syscampo SET descricao = 'Licitação', rotulo = 'Licitação', rotulorel = 'Licitação' WHERE nomecam = 'l221_licitacao';

        UPDATE db_syscampo SET descricao = 'Número da Ata', rotulo = 'Número da Ata', rotulorel = 'Número da Ata' WHERE nomecam = 'l221_numata';

        UPDATE db_syscampo SET descricao = 'Exercício da Ata', rotulo = 'Exercício da Ata', rotulorel = 'Exercício da Ata' WHERE nomecam = 'l221_exercicio';

        UPDATE db_syscampo SET descricao = 'Data de Publicação', rotulo = 'Data de Publicação', rotulorel = 'Data de Publicação' WHERE nomecam = 'l221_datapublica';

        UPDATE db_syscampo SET descricao = 'Veículo de Publicação', rotulo = 'Veículo de Publicação', rotulorel = 'Veículo de Publicação' WHERE nomecam = 'l221_veiculopublica';

        UPDATE db_syscampo SET descricao = 'Descrição Item', rotulo = 'Descrição Item', rotulorel = 'Descrição Item' WHERE nomecam = 'l222_descricao';

        COMMIT;

        
        
        ";

        
       
       
        $this->execute($sql);

    }
}
