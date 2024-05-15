<?php

use Phinx\Migration\AbstractMigration;

class InserirMenusEventosSaudeSecTrabalho extends AbstractMigration
{
    
    private $idVersaoFormulario = 53;
    private $idFormularioTipo = 59;
    private $idModEsocial = 10216;

    public function up()
    {

        $arrMenus = array(
            's2210' => 'S-2210 - Comunicação de Acidente de Trabalho',
            's2220' => 'S-2220 - Monitoramento da Saúde do Trabalhador',
            's2240' => 'S-2240 - Condições Ambientais do Trabalho - Agentes Nocivos'
        );

        $sSql = $this->getSqlMainMenu();
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
        DELETE FROM db_itensmenu WHERE id_item IN (SELECT id_item_filho FROM db_itensmenu JOIN db_menu ON db_itensmenu.id_item = db_menu.id_item WHERE descricao ILIKE 'Eventos de SST - Sa%de e Seguran%a do Trabalho');
        DELETE FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Eventos de SST - Sa%de e Seguran%a do Trabalho') AND modulo = {$this->idModEsocial};
        ";
        $this->execute($sSql);
    }

    private function getSqlMainMenu()
    {
        return "
        INSERT INTO db_itensmenu VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),'Eventos de SST - Saúde e Segurança do Trabalho','Eventos de SST - Saúde e Segurança do Trabalho','',1,1,'Eventos de SST - Saúde e Segurança do Trabalho','t');
        INSERT INTO db_menu VALUES (10466,(SELECT MAX(id_item) FROM db_itensmenu),(SELECT MAX(menusequencia) FROM db_menu WHERE id_item = 10466),10216);
        ";
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
        VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Eventos de SST - Sa%de e Seguran%a do Trabalho'),
            (SELECT MAX(id_item) FROM db_itensmenu),
            (SELECT coalesce(MAX(menusequencia),0) FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Eventos de SST - Sa%de e Seguran%a do Trabalho')),
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
