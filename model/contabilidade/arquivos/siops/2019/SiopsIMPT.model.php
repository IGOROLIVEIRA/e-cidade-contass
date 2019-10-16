<?php

require_once("model/contabilidade/arquivos/siops/" . db_getsession("DB_anousu") . "/Siops.model.php");

class SiopeCsv extends Siope {

    //@var String
    protected $sArquivo;

    //@var String
    protected $sDelim = ";";

    //@var String
    protected $_arquivo;

    //@var String
    protected $sLinha;

    public function gerarArquivoIMPT(array $aDados, $tipo = null) {


        $this->sArquivo = $this->getNomeArquivo();
        $this->abreArquivo();

        foreach ($aDados as $value) {


        }

        $this->fechaArquivo();

    }

    function abreArquivo() {
        $this->_arquivo = fopen($this->sArquivo . '.IMPT', "w");
    }

    function fechaArquivo() {
        fclose($this->_arquivo);
    }

}
