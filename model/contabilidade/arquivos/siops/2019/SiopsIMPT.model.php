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

    public function gerarArquivoIMPT(array $aDados, $tipo = null) {

        if ($tipo == 1) {

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
                $sLinha .= "#C7" . $this->sDelim;

                fputs($this->_arquivo, utf8_encode($sLinha));
                fputs($this->_arquivo, "\r\n");

            }

            $this->fechaArquivo();

        } elseif($tipo == 2) {

            $this->sArquivo = $this->getNomeArquivo();
            $this->abreArquivo();

            foreach ($aDados as $value) {

                $sLinha  = "1" . $this->sDelim;
                $sLinha .= $this->getNaturezaFormat($value['natureza']) . $this->sDelim;
                $sLinha .= $value['campo'] . $this->sDelim;
                $sLinha .= "V0:[>R$" . number_format($value['prev_inicial'], 2, ',', '') . "<]:-[17](Previsão Inicial das Receitas Brutas (a))" . $this->sDelim;
                $sLinha .= "V1:[>R$" . number_format($value['prev_atualizada'], 2, ',', '') . "<]:-[15](Previsão Atualizada das Receitas Brutas (b))" . $this->sDelim;
                $sLinha .= "V2:[>R$" . number_format($value['rec_realizada'], 2, ',', '') . "<]:-[18](Receitas Realizadas Brutas (c))".$this->sDelim;
                $sLinha .= "V3:[>R$" . number_format($value['ded_receita'], 2, ',', '') . "<]:-[6](Deduções das Receitas (d))".$this->sDelim;
                $sLinha .= "V4:[>R$" . number_format($value['rec_asps'], 2, ',', '') . "<]:-[20](Receitas Realizadas da base para cálculo do percentual de aplicacao em ASPS (e) = (c-d))".$this->sDelim;
                $sLinha .= "V5:[>R$" . number_format($value['ded_fundeb'], 2, ',', '') . "<]:-[5](Dedução Para Formação do FUNDEB (f))".$this->sDelim;
                $sLinha .= "V6:[>R$" . number_format($value['total_receitas'], 2, ',', '') . "<]:-[24](Total Geral das Receitas Liquidas Realizadas (g) = (c-d-f)".$this->sDelim;
                $sLinha .= "V7:[>R$" . number_format($value['rec_orcada'], 2, ',', '') . "<]:-[22](Receitas Orçadas)".$this->sDelim;
                $sLinha .= $value['linha'] . $this->sDelim;
                $sLinha .= "#C8" . $this->sDelim;

                fputs($this->_arquivo, utf8_encode($sLinha));
                fputs($this->_arquivo, "\r\n");

            }

            $this->fechaArquivo();

        }

    }

    function abreArquivo() {
        $this->_arquivo = fopen($this->sArquivo . '.IMPT', "w");
    }

    function fechaArquivo() {
        fclose($this->_arquivo);
    }

}
