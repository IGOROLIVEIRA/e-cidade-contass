<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_terem102017_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2017/flpg/GerarTEREM.model.php");

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

    $clterem10 = new cl_terem102017();

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
     * selecionar informacoes registro 10
     */

    $sSql = "select round(te01_valor,2) as te01_valor , te01_justificativa, te01_dtinicial, te01_dtfinal, te01_tipocadastro  from tetoremuneratorio";//" where ";
//    $sSql .= " DATE_PART('YEAR',te01_dtinicial) >= ".db_getsession("DB_anousu")." and DATE_PART('YEAR',te01_dtfinal) <= ".db_getsession("DB_anousu");
//    $sSql .= " and round(te01_valor,2) not in (select round(si194_vlrparateto,2) from terem102017 where si194_mes <= ".($this->sDataFinal['5'].$this->sDataFinal['6'])." )";
//    $sSql .= " and round(te01_valor,2) not in (select round(si194_vlrparateto,2) from terem102015)";
//    $sSql .= " and round(te01_valor,2) not in (select round(si194_vlrparateto,2) from terem102014)";
//    $sSql .= " and round(te01_valor,2) not in (select round(si194_vlrparateto,2) from terem102013)";

    $rsResult10 = db_query($sSql);//echo $sSql;db_criatabela($rsResult10);exit;



    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clterem10 = new cl_terem102017();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clterem10->si194_tiporegistro          = 10;
      $clterem10->si194_vlrparateto           = $oDados10->te01_valor;
      $clterem10->si194_cnpj                  = $CNPJ;//$oDados10->si194_vlrparateto;
      $clterem10->si194_tipocadastro          = $oDados10->te01_tipocadastro;
      $clterem10->si194_dtinicial             = $oDados10->te01_dtinicial;
      $clterem10->si194_dtfinal               = $oDados10->te01_dtfinal;
      $clterem10->si194_justalteracao         = $oDados10->te01_justificativa;
      $clterem10->si194_mes                   = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clterem10->si194_inst                  = db_getsession("DB_instit");

      $clterem10->incluir(null);
      if ($clterem10->erro_status == 0) {
        throw new Exception($clterem10->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarTEREM = new GerarTEREM();
    $oGerarTEREM->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarTEREM->gerarDados();

  }

}
