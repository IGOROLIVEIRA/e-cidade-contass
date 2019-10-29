<?php

require_once("model/contabilidade/arquivos/siope/" . db_getsession("DB_anousu") . "/Siope.model.php");

class SiopeCsv extends Siope {

    //@var String
    protected $sArquivo;

    //@var String
    protected $sDelim = ";";

    //@var String
    protected $_arquivo;

    //@var String
    protected $sLinha;

    public function gerarArquivoCSV(array $aDados, $tipo = null) {

        if ($tipo == 1) {

            $this->sArquivo = $this->getNomeArquivo();
            $this->abreArquivo();

            foreach ($aDados as $value) {

                $sLinha = "V;1;" . $value['cod_planilha'] . $this->sDelim;
                $sLinha .= $this->getElementoFormat($value['elemento_siope']) . $this->sDelim;
                $sLinha .= $value['descricao_siope'] . $this->sDelim;
                $sLinha .= number_format($value['dot_atualizada'], 2, ',', '') . $this->sDelim;
                $sLinha .= number_format($value['empenhado'], 2, ',', '') . $this->sDelim;
                $sLinha .= number_format($value['liquidado'], 2, ',', '') . $this->sDelim;
                $sLinha .= number_format($value['pagamento'], 2, ',', '') . $this->sDelim;
                $sLinha .= number_format($value['desp_orcada'], 2, ',', '') . $this->sDelim;

                fputs($this->_arquivo, $sLinha);
                fputs($this->_arquivo, "\r\n");
            }

            $this->fechaArquivo();

        } elseif ($tipo == 2) {

            $this->sArquivo = $this->getNomeArquivo();
            $this->abreArquivo();

            foreach ($aDados as $value) {

                if (!($value['prev_atualizada'] == 0 && $value['rec_realizada'] == 0 && $value['rec_orcada'] == 0)) {

                    $sLinha = "V;1;1" . $this->sDelim;
                    $sLinha .= $this->getNaturezaFormat($value['natureza']) . $this->sDelim;
                    $sLinha .= $value['descricao'] . $this->sDelim;
                    $sLinha .= number_format($value['prev_atualizada'], 2, ',', '') . $this->sDelim;
                    $sLinha .= number_format($value['rec_realizada'], 2, ',', '') . $this->sDelim;
                    $sLinha .= number_format($value['rec_orcada'], 2, ',', '') . $this->sDelim;

                    fputs($this->_arquivo, $sLinha);
                    fputs($this->_arquivo, "\r\n");

                }

            }

            $this->fechaArquivo();

        }

    }

    function abreArquivo() {
        $this->_arquivo = fopen($this->sArquivo . '.csv', "w");
    }

    function fechaArquivo() {
        fclose($this->_arquivo);
    }

    function adicionaLinha() {
        $aLinha = array();

        foreach ($this->sLinha as $sLinha) {
            $aLinha[] = $sLinha;
        }

        $sLinha = implode(";", $aLinha);

    }

}
