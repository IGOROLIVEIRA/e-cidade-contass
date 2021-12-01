<?php

use Phinx\Migration\AbstractMigration;

class InserirMenusPeriodicos extends AbstractMigration
{

    private $idVersaoFormulario = 20;
    private $idFormularioTipo = 26;
    private $idModEsocial = 10216;

    public function up()
    {

        $arrMenus = array(
            's1200' => 'S-1200 - Remuneração de Trabalhador vinculado ao Regime Geral de Previd. Social',
            's1202' => 'S-1202 - Remuneração de Servidor vinculado ao Regime Próprio de Previd. Social',
            's1207' => 'S-1207 - Benefícios - Entes Públicos',
            's1210' => 'S-1210 - Pagamentos de Rendimentos do Trabalho',
            's1260' => 'S-1260 - Comercialização da Produção Rural Pessoa Física',
            's1270' => 'S-1270 - Contratação de Trabalhadores Avulsos Não Portuários',
            's1280' => 'S-1280 - Informações Complementares aos Eventos Periódicos',
            's1298' => 'S-1298 - Reabertura dos Eventos Periódicos',
            's1299' => 'S-1299 - Fechamento dos Eventos Periódicos');

        $sSql = "";
        $this->idVersaoFormulario++;
        $this->idFormularioTipo++;
        foreach ($arrMenus as $keyMenu => $descMenu) {
            $sSql .= $this->getSqlAddMenu($keyMenu, $descMenu);
            $sSql .= $this->getSqlAddFormTipo($keyMenu, $descMenu);
            $this->idVersaoFormulario++;
            $this->idFormularioTipo++;
        }
        $sSql .= $this->getSqlSetSequence();

        $this->execute($sSql);
    }

    public function down()
    {
        $sSql = "
        DELETE FROM esocialversaoformulario WHERE rh211_sequencial > {$this->idVersaoFormulario};
        DELETE FROM esocialformulariotipo WHERE rh209_sequencial > {$this->idFormularioTipo};
        DELETE FROM db_itensmenu WHERE id_item IN (SELECT id_item_filho FROM db_itensmenu JOIN db_menu ON db_itensmenu.id_item = db_menu.id_item WHERE descricao ILIKE 'Peri%dicos');
        DELETE FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Peri%dicos') AND modulo = {$this->idModEsocial};
        ";
        $this->execute($sSql);
    }

    private function getSqlSetSequence()
    {
        return "
        SELECT setval('esocialformulariotipo_rh209_sequencial_seq', (SELECT max(rh209_sequencial) FROM esocialformulariotipo));
        SELECT setval('esocialversaoformulario_rh211_sequencial_seq', (SELECT max(rh211_sequencial) FROM esocialversaoformulario));
        ";
    }

    private function getSqlAddMenu($keyMenu, $descMenu)
    {
        return "
        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            '{$descMenu}',
            '{$descMenu}',
            (SELECT 'con4_manutencaoformulario001.php?esocial='||max(rh209_sequencial)::varchar FROM esocialformulariotipo),
            1,
            1,
            '{$descMenu}',
            't');

        INSERT INTO db_menu 
        VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Peri%dicos'),
            (SELECT MAX(id_item) FROM db_itensmenu),
            (SELECT coalesce(MAX(menusequencia),0) FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Peri%dicos')),
            {$this->idModEsocial});
        ";
    }

    private function getSqlAddFormTipo($keyMenu, $descMenu)
    {
        if ($this->checkFormularioTipo()) {
            return "
            INSERT INTO esocialformulariotipo 
            (rh209_sequencial,rh209_descricao) VALUES ({$this->idFormularioTipo},'{$descMenu}');
            INSERT INTO esocialversaoformulario (rh211_sequencial, rh211_versao, rh211_avaliacao, rh211_esocialformulariotipo) VALUES ({$this->idVersaoFormulario}, '1.0', (SELECT db101_sequencial FROM avaliacao WHERE db101_identificador='{$keyMenu}-vs1'), (SELECT max(rh209_sequencial) FROM esocialformulariotipo));
            ";
        }
        return "";
    }

    private function checkFormularioTipo()
    {
        $result = $this->fetchRow("SELECT * FROM esocialformulariotipo WHERE rh209_sequencial = {$this->idFormularioTipo}");
        if (empty($result)) {
            return true;
        }
        return false; 
    }
}
