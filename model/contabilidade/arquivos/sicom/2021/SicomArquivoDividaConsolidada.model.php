<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ddc102021_classe.php");
require_once ("classes/db_ddc202121_classe.php");
require_once ("classes/db_ddc302021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarDDC.model.php");

 /**
  * Divida Consolidada Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDividaConsolidada extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'DDC';
  
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
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   */
  public function getCampos(){
   
  }
  
  /**
   * Parecer da Licitação do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
    $clddc102021 = new cl_ddc102021();
    $clddc202121 = new cl_ddc202121();
    $clddc302021 = new cl_ddc302021();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clddc102021->sql_record($clddc102021->sql_query(NULL,"*",NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc102021->excluir(NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc102021->erro_status == 0) {
        throw new Exception($clddc102021->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clddc202121->sql_record($clddc202121->sql_query(NULL,"*",NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc202121->excluir(NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc202121->erro_status == 0) {
        throw new Exception($clddc202121->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clddc302021->sql_record($clddc302021->sql_query(NULL,"*",NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc302021->excluir(NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc302021->erro_status == 0) {
        throw new Exception($clddc302021->erro_msg);
      }
    }
    
    $sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
      
    /*
     * selecionar informacoes registro 10
     */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    
    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clddc102021 = new cl_ddc102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clddc102021->si150_tiporegistro                   = 10;
      $clddc102021->si150_codorgao                       = $sCodorgao;
      $clddc102021->si150_nroleiautorizacao              = $oDados10->si167_nroleiautorizacao;
      $clddc102021->si150_dtleiautorizacao               = $oDados10->si167_dtleiautorizacao;
      $clddc102021->si150_dtpublicacaoleiautorizacao     = $oDados10->si167_dtpublicacaoleiautorizacao;
      $clddc102021->si150_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc102021->incluir(null);
      if ($clddc102021->erro_status == 0) {
        throw new Exception($clddc102021->erro_msg);
      }
      
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clddc202121 = new cl_ddc202121();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clddc202121->si153_tiporegistro                     = 20;
      $clddc202121->si153_codorgao                         = $sCodorgao;
      $clddc202121->si153_nrocontratodivida                = $oDados20->si167_nrocontratodivida;
      $clddc202121->si153_dtassinatura                     = $oDados20->si167_dtassinatura;
      $clddc202121->si153_contratodeclei                   = $oDados20->si167_contratodeclei;
      $clddc202121->si153_nroleiautorizacao                = $oDados20->si167_nroleiautorizacao;
      $clddc202121->si153_dtleiautorizacao                 = $oDados20->si167_dtleiautorizacao;
      $clddc202121->si153_objetocontratodivida             = $oDados20->si167_objetocontratodivida;
      $clddc202121->si153_especificacaocontratodivida      = $oDados20->si167_especificacaocontratodivida;
      $clddc202121->si153_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc202121->incluir(null);
      if ($clddc202121->erro_status == 0) {
        throw new Exception($clddc202121->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 30
    */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      
      $clddc302021 = new cl_ddc302021();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      
      $clddc302021->si154_tiporegistro               = 30;
      $clddc302021->si154_codorgao                   = $sCodorgao;
      $clddc302021->si154_nrocontratodivida          = $oDados30->si167_nrocontratodivida;
      $clddc302021->si154_dtassinatura               = $oDados30->si167_dtassinatura;
      $clddc302021->si154_tipolancamento             = $oDados30->si167_tipolancamento;
      $clddc302021->si154_tipodocumentocredor        = $oDados30->si167_tipodocumentocredor;
      $clddc302021->si154_nrodocumentocredor         = $oDados30->si167_nrodocumentocredor;
      $clddc302021->si154_justificativacancelamento  = "";
      $clddc302021->si154_vlsaldoanterior            = $oDados30->si167_vlsaldoanterior;
      $clddc302021->si154_vlcontratacao              = $oDados30->si167_vlcontratacao;
      $clddc302021->si154_vlamortizacao              = $oDados30->si167_vlamortizacao;
      $clddc302021->si154_vlcancelamento             = $oDados30->si167_vlcancelamento;
      $clddc302021->si154_vlencampacao               = $oDados30->si167_vlencampacao;
      $clddc302021->si154_vlatualizacao              = $oDados30->si167_vlatualizacao;
      $clddc302021->si154_vlsaldoatual               = $oDados30->si167_vlsaldoatual;
      $clddc302021->si154_mes                        = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc302021->incluir(null);
      if ($clddc302021->erro_status == 0) {
        throw new Exception($clddc302021->erro_msg);
      }
      
    }
    
    db_fim_transacao();
    
    $oGerarDDC = new GerarDDC();
    $oGerarDDC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDDC->gerarDados();
    
  }
		
}			
