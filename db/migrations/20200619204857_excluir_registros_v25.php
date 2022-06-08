<?php

use Classes\PostgresMigration;

class ExcluirRegistrosV25 extends PostgresMigration
{

    public function up()
    {
        $this->deleteLayoutEsocial('formulario-s1030-v2402');
        $this->deleteLayoutEsocial('formulario-s1035-v2402');
        $this->deleteLayoutEsocial('formulario-s1040-v2402');
        $this->deleteLayoutEsocial('formulario-s1050-v2402');
        $this->deleteLayoutEsocial('formulario-s1060-v25');
        $this->deleteLayoutEsocial('formulario-s1080-v25');
        
    }

    public function down() 
    {
        $idAvaliacao = $this->getIdAvaliacao('formulario-s1035-v2402');
        var_dump(implode(',',$this->getIdAvaliacaoGrupoPergunta($idAvaliacao)));
    }

    private function getIdAvaliacao($identificador)
    {
        $idAvaliacao = $this->fetchRow("SELECT db101_sequencial FROM avaliacao WHERE db101_identificador = '{$identificador}'");
        return $idAvaliacao['db101_sequencial'];
    }

    private function getIdAvaliacaoGrupoPergunta($idAvaliacao)
    {
        $arrIdAvaliacaoGrupoPergunta = array();
        $allResults = $this->fetchAll("SELECT db102_sequencial FROM avaliacaogrupopergunta WHERE db102_avaliacao = {$idAvaliacao}");
        foreach ($allResults as $result) {
            $arrIdAvaliacaoGrupoPergunta[] = $result['db102_sequencial'];
        }
        return $arrIdAvaliacaoGrupoPergunta;
    }

    private function getIdEsocialFormularioTipo($idAvaliacao)
    {
        $result = $this->fetchRow("SELECT rh211_esocialformulariotipo FROM esocialversaoformulario WHERE rh211_avaliacao = {$idAvaliacao}");
        return $result['rh211_esocialformulariotipo'];
    }

    private function getIdAvaliacaoPergunta($arrIdAvaliacaoGrupoPergunta)
    {
        $arrIdAvaliacaoPergunta = array();
        $allResults = $this->fetchAll("SELECT db103_sequencial FROM avaliacaopergunta WHERE db103_avaliacaogrupopergunta IN (".implode(',',$arrIdAvaliacaoGrupoPergunta).")");
        foreach ($allResults as $result) {
            $arrIdAvaliacaoPergunta[] = $result['db103_sequencial'];
        }
        return $arrIdAvaliacaoPergunta;
    }

    private function deleteLayoutEsocial($identificador)
    {
        $idAvaliacao = $this->getIdAvaliacao($identificador);
        $arrIdAvaliacaoGrupoPergunta = $this->getIdAvaliacaoGrupoPergunta($idAvaliacao);
        $idEsocialFormularioTipo = $this->getIdEsocialFormularioTipo($idAvaliacao);
        $arrIdAvaliacaoPergunta = $this->getIdAvaliacaoPergunta($arrIdAvaliacaoGrupoPergunta);

        $this->execute("DELETE FROM avaliacaoperguntaopcao WHERE db104_avaliacaopergunta IN (".implode(',',$arrIdAvaliacaoPergunta).")");
        $this->execute("DELETE FROM avaliacaopergunta WHERE db103_avaliacaogrupopergunta IN (".implode(',',$arrIdAvaliacaoGrupoPergunta).")");
        $this->execute("DELETE FROM esocialversaoformulario WHERE rh211_avaliacao = {$idAvaliacao}");
        $this->execute("DELETE FROM esocialformulariotipo WHERE rh209_sequencial = {$idEsocialFormularioTipo}");
        $this->execute("DELETE FROM avaliacaogrupopergunta WHERE db102_avaliacao = {$idAvaliacao}");
        $this->execute("DELETE FROM avaliacao WHERE db101_sequencial = {$idAvaliacao}");
    }
}
