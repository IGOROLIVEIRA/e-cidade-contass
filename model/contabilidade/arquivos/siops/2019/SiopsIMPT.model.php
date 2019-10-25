<?php

require_once("model/contabilidade/arquivos/siops/" . db_getsession("DB_anousu") . "/Siops.model.php");

class SiopeIMPT extends Siops {

    //@var String
    protected $sArquivo;

    //@var String
    protected $sDelim = ";";

    //@var String
    protected $_arquivo;

    //@var String
    protected $sLinha;

    public function gerarArquivoIMPT(array $aDados) {

        $this->sArquivo = $this->getNomeArquivo();
        $this->abreArquivo();

        foreach ($aDados as $value) {

            $sLinha = $value['cod_planilha'] . $this->sDelim;
            $sLinha .= $this->getElementoFormat($value['elemento_siops']) . $this->sDelim;
            $sLinha .= $value['campo_siops'] . $this->sDelim;
            $sLinha .= "V0:[>R$" . number_format($value['dot_inicial'], 2, ',', '') . "<]:-[13](Dotação Inicial)" . $this->sDelim;
            $sLinha .= "V1:[>R$" . number_format($value['dot_atualizada'], 2, ',', '') . "<]:-[12](Dotação Atualizada)" . $this->sDelim;
            $sLinha .= "V2:[>R$" . number_format($value['empenhado'], 2, ',', '') . "<]:-[9](Despesas Empenhadas)" . $this->sDelim;
            $sLinha .= "V3:[>R$" . number_format($value['liquidado'], 2, ',', '') . "<]:-[10](Despesas Liquidadas)" . $this->sDelim;
            $sLinha .= "V4:[>R$" . number_format($value['pagamento'], 2, ',', '') . "<]:-[11](Despesas Pagas)" . $this->sDelim;
            $sLinha .= "V5:[>R$" . number_format($value['inscritas_rpnp'], 2, ',', '') . "<]:-[14](Inscritas em Restos a Pagar Não Processados)" . $this->sDelim;
            $sLinha .= "V6:[>R$" . number_format($value['desp_orcada'], 2, ',', '') . "<]:-[8](Despesas Orçadas)" . $this->sDelim;
            $sLinha .= $value['linha_siops'] . $this->sDelim;
            $sLinha .= "#C7" . $this->sDelim;;

            fputs($this->_arquivo, $sLinha);
            fputs($this->_arquivo, "\r\n");

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
