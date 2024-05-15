<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_terem102020_classe.php");
require_once ("classes/db_tetoremuneratorio_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/flpg/GerarTEREM.model.php");

/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */

class SicomArquivoTerem extends SicomArquivoBase implements iPadArquivoBaseCSV {

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'TEREM';

    /**
     *
     * Construtor da classe
     */
    public function __construct() {

    }

    /**
     * Retorna o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout(){

    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos(){

    }

    /**
     * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados() {

        $sSql  = "SELECT db21_codigomunicipoestado AS codmunicipio,
                cgc::varchar AS cnpjmunicipio,
                si09_tipoinstit AS tipoorgao,
                si09_codorgaotce AS codorgao,
                prefeitura
              FROM db_config
              LEFT JOIN infocomplementaresinstit ON si09_instit = ".db_getsession("DB_instit")."
              WHERE codigo = ".db_getsession("DB_instit");

        $rsResult  = db_query($sSql);

        $CNPJ = db_utils::fieldsMemory($rsResult, 0)->cnpjmunicipio;

        $clterem10 = new cl_terem102020();
        $clterem20 = new cl_terem202020();

        db_inicio_transacao();

        /*
         * excluir informacoes do mes selecionado registro 10
         */
        $result = $clterem10->sql_record($clterem10->sql_query(NULL,"*",NULL,"si194_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
        if (pg_num_rows($result) > 0) {
            $clterem10->excluir(NULL,"si194_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
            if ($clterem10->erro_status == 0) {
                throw new Exception($clterem10->erro_msg);
            }
        }
        /*
         * excluir informacoes do mes selecionado registro 20
         */
        $result = $clterem20->sql_record($clterem20->sql_query(NULL,"*",NULL,"si196_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
        if (pg_num_rows($result) > 0) {
            $clterem20->excluir(NULL,"si196_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
            if ($clterem20->erro_status == 0) {
                throw new Exception($clterem20->erro_msg);
            }
        }

        $sSql = "select round(te01_valor,2) as te01_valor
              ,te01_codteto 
              ,te01_justificativa
              ,te01_dtinicial
              ,te01_dtfinal
              ,te01_tipocadastro
              ,te01_dtpublicacaolei
              ,te01_nrleiteto
              ,te01_sequencial
              from tetoremuneratorio
              where DATE_PART('YEAR',te01_dtinicial)  = ".db_getsession("DB_anousu") ."
              and   DATE_PART('MONTH',te01_dtinicial) = ". $this->sDataFinal['5'].$this->sDataFinal['6'] ."
              and te01_codteto not in (select si196_codteto from terem202020)
              ";

        $rsResult = db_query($sSql);//echo $sSql;db_criatabela($rsResult);exit;

        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oDados = db_utils::fieldsMemory($rsResult, $iCont);

            $clterem10 = new cl_terem102020();

            $clterem10->si194_tiporegistro          = 10;

            $clterem10->si194_vlrparateto           = $oDados->te01_valor;
            $clterem10->si194_cnpj                  = $CNPJ;//$oDados->si194_vlrparateto;
            $clterem10->si194_codteto               = $oDados->te01_codteto;//$oDados->si194_vlrparateto;

            $clterem10->si194_tipocadastro          = $oDados->te01_tipocadastro;

            $clterem10->si194_dtinicial             = $oDados->te01_dtinicial;

            $ToDataFinal                            = date('Y-m-d',strtotime(implode('-', array_reverse(explode('/', $oDados->te01_dtinicial)))));

            $clterem10->si194_dtfinal               = date('Y-m-d',strtotime("-1 days", strtotime($ToDataFinal)));

            $clterem10->si194_nrleiteto             = $oDados->te01_nrleiteto;
            $clterem10->si194_dtpublicacaolei       = $oDados->te01_dtpublicacaolei;
            $clterem10->si194_justalteracao         = $oDados->te01_justificativa;
            $clterem10->si194_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
            $clterem10->si194_inst                  = db_getsession("DB_instit");

            $clterem10->incluir(null);
            if ($clterem10->erro_status == 0) {
                throw new Exception($clterem10->erro_msg);
            }


        }

        $sSql = "SELECT round(te01_valor,2) as te01_valor
              ,te01_codteto 
              ,te01_justificativa
              ,te01_dtinicial
              ,te01_dtfinal
              ,te01_tipocadastro
              ,te01_dtpublicacaolei
              ,te01_nrleiteto
              ,te01_sequencial
              ,te01_codteto
              FROM tetoremuneratorio
              WHERE DATE_PART('YEAR',te01_dtinicial)  = ".db_getsession("DB_anousu") ."
              AND te01_codteto = (select si194_codteto from terem102020
              where si194_codteto = te01_codteto
                  and (
                       si194_vlrparateto     <> te01_valor
                       or
                       si194_nrleiteto       <> te01_nrleiteto
                       or
                       si194_dtpublicacaolei <> te01_dtpublicacaolei 
                      )  
              )";

        $rsResult = db_query($sSql);//echo $sSql;db_criatabela($rsResult);exit;


        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oDados = db_utils::fieldsMemory($rsResult, $iCont);

            $clterem20 = new cl_terem202020();

            $clterem20->si196_tiporegistro          = 20;
            $clterem20->si196_vlrparateto           = $oDados->te01_valor;
            $clterem20->si196_cnpj                  = $CNPJ;//$oDados->si194_vlrparateto;
            $clterem20->si196_codteto               = $oDados->te01_codteto;//$oDados->si194_vlrparateto;
            $clterem20->si196_tipocadastro          = 2;
            $clterem20->si196_dtinicial             = $oDados->te01_dtinicial;

            $dtfinal                                = date('Y-m-d', strtotime("-1 days", strtotime($oDados->te01_dtinicial)));
            $clterem20->si196_dtfinal               = $dtfinal;

            $clterem20->si196_nrleiteto             = $oDados->te01_nrleiteto;
            $clterem20->si196_dtpublicacaolei       = $oDados->te01_dtpublicacaolei;
            $clterem20->si196_justalteracaoteto     = $oDados->te01_justificativa;
            $clterem20->si196_mes                   = $this->sDataFinal['5'] . $this->sDataFinal['6'];
            $clterem20->si196_inst                  = db_getsession("DB_instit");

            $clterem20->incluir(null);

            if ($clterem20->erro_status == 0) {
                throw new Exception($clterem20->erro_msg);
            }

        }

        db_fim_transacao();

        $oGerarTEREM = new GerarTEREM();

        $oGerarTEREM->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];

        $oGerarTEREM->gerarDados();

    }

}
