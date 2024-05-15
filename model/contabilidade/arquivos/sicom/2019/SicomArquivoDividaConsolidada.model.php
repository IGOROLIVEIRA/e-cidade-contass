<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ddc102014_classe.php");
require_once ("classes/db_ddc202014_classe.php");
require_once ("classes/db_ddc302014_classe.php");
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
    
    $clddc102014 = new cl_ddc102014();
    $clddc202014 = new cl_ddc202014();
    $clddc302014 = new cl_ddc302014();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clddc102014->sql_record($clddc102014->sql_query(NULL,"*",NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc102014->excluir(NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc102014->erro_status == 0) {
        throw new Exception($clddc102014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clddc202014->sql_record($clddc202014->sql_query(NULL,"*",NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc202014->excluir(NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc202014->erro_status == 0) {
        throw new Exception($clddc202014->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clddc302014->sql_record($clddc302014->sql_query(NULL,"*",NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc302014->excluir(NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc302014->erro_status == 0) {
        throw new Exception($clddc302014->erro_msg);
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
      
      $clddc102014 = new cl_ddc102014();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clddc102014->si150_tiporegistro                   = 10;
      $clddc102014->si150_codorgao                       = $sCodorgao;
      $clddc102014->si150_nroleiautorizacao              = $oDados10->si167_nroleiautorizacao;
      $clddc102014->si150_dtleiautorizacao               = $oDados10->si167_dtleiautorizacao;
      $clddc102014->si150_dtpublicacaoleiautorizacao     = $oDados10->si167_dtpublicacaoleiautorizacao;
      $clddc102014->si150_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc102014->incluir(null);
      if ($clddc102014->erro_status == 0) {
        throw new Exception($clddc102014->erro_msg);
      }
      
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clddc202014 = new cl_ddc202014();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clddc202014->si153_tiporegistro                     = 20;
      $clddc202014->si153_codorgao                         = $sCodorgao;
      $clddc202014->si153_nrocontratodivida                = $oDados20->si167_nrocontratodivida;
      $clddc202014->si153_dtassinatura                     = $oDados20->si167_dtassinatura;
      $clddc202014->si153_contratodeclei                   = $oDados20->si167_contratodeclei;
      $clddc202014->si153_nroleiautorizacao                = $oDados20->si167_nroleiautorizacao;
      $clddc202014->si153_dtleiautorizacao                 = $oDados20->si167_dtleiautorizacao;
      $clddc202014->si153_objetocontratodivida             = $oDados20->si167_objetocontratodivida;
      $clddc202014->si153_especificacaocontratodivida      = $oDados20->si167_especificacaocontratodivida;
      $clddc202014->si153_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc202014->incluir(null);
      if ($clddc202014->erro_status == 0) {
        throw new Exception($clddc202014->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 30
    */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      
      $clddc302014 = new cl_ddc302014();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      
      $clddc302014->si154_tiporegistro               = 30;
      $clddc302014->si154_codorgao                   = $sCodorgao;
      $clddc302014->si154_nrocontratodivida          = $oDados30->si167_nrocontratodivida;
      $clddc302014->si154_dtassinatura               = $oDados30->si167_dtassinatura;
      $clddc302014->si154_tipolancamento             = $oDados30->si167_tipolancamento;
      $clddc302014->si154_tipodocumentocredor        = $oDados30->si167_tipodocumentocredor;
      $clddc302014->si154_nrodocumentocredor         = $oDados30->si167_nrodocumentocredor;
      $clddc302014->si154_justificativacancelamento  = "";
      $clddc302014->si154_vlsaldoanterior            = $oDados30->si167_vlsaldoanterior;
      $clddc302014->si154_vlcontratacao              = $oDados30->si167_vlcontratacao;
      $clddc302014->si154_vlamortizacao              = $oDados30->si167_vlamortizacao;
      $clddc302014->si154_vlcancelamento             = $oDados30->si167_vlcancelamento;
      $clddc302014->si154_vlencampacao               = $oDados30->si167_vlencampacao;
      $clddc302014->si154_vlatualizacao              = $oDados30->si167_vlatualizacao;
      $clddc302014->si154_vlsaldoatual               = $oDados30->si167_vlsaldoatual;
      $clddc302014->si154_mes                        = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc302014->incluir(null);
      if ($clddc302014->erro_status == 0) {
        throw new Exception($clddc302014->erro_msg);
      }
      
    }
    
    db_fim_transacao();
    
    $oGerarDDC = new GerarDDC();
    $oGerarDDC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDDC->gerarDados();
    
  }
		
}			
