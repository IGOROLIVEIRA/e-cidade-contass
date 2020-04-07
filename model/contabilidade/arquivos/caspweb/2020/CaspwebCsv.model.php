<?php

require_once("model/contabilidade/arquivos/caspweb/" . db_getsession("DB_anousu") . "/Caspweb.model.php");

class CaspwebCsv extends Caspweb {

    //@var String
    protected $sArquivo;

    //@var String
    protected $sDelim = ";";

    //@var String
    protected $_arquivo;

    //@var String
    protected $sLinha;

    public function gerarArquivoCSV($rsDados) {

        $this->sArquivo = $this->getNomeArquivo();
        $this->abreArquivo();

        for ($iCont = 0; $iCont < pg_num_rows($rsDados); $iCont++) {

            $oLinhaMapa = db_utils::fieldsMemory($rsDados, $iCont);

            $sLinha = "";

            foreach($oLinhaMapa as $sIndex => $sItem) {
                $sLinha .= ($sItem != null || $sItem != "") ? $sItem.$this->sDelim : " ".$this->sDelim;
            }

            fputs($this->_arquivo, $sLinha);
            fputs($this->_arquivo, "\r\n");

        }

        $this->fechaArquivo();

    }

    function abreArquivo() {
        $this->_arquivo = fopen($this->sArquivo . '.csv', "w");
    }

    function fechaArquivo() {
        fclose($this->_arquivo);
    }

//    function adicionaLinha() {
//        $aLinha = array();
//
//        foreach ($this->sLinha as $sLinha) {
//            $aLinha[] = $sLinha;
//        }
//
//        $sLinha = implode(";", $aLinha);
//
//    }

}
