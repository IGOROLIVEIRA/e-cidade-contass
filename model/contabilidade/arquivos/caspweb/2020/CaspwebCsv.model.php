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

    public function gerarArquivoCSV($aDados) {

        $this->sArquivo = $this->getNomeArquivo();
        $this->abreArquivo();

        foreach ($aDados as $sItens) {

            $sLinha = "";

            foreach ($sItens as $chave => $sItem) {
                if ($chave == 'debito' || $chave == 'credito') {
                    $sLinha .= number_format($sItem,2,',','') . $this->sDelim;
                } else {
                    $sLinha .= ($sItem != null || $sItem != "") ? $sItem . $this->sDelim : " " . $this->sDelim;
                }
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

}
