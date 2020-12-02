<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ddc10$PROXIMO_ANO_classe.php");
require_once ("classes/db_ddc20$PROXIMO_ANO_classe.php");
require_once ("classes/db_ddc30$PROXIMO_ANO_classe.php");
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
    
    $clddc10$PROXIMO_ANO = new cl_ddc10$PROXIMO_ANO();
    $clddc20$PROXIMO_ANO = new cl_ddc20$PROXIMO_ANO();
    $clddc30$PROXIMO_ANO = new cl_ddc30$PROXIMO_ANO();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clddc10$PROXIMO_ANO->sql_record($clddc10$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc10$PROXIMO_ANO->excluir(NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc10$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clddc10$PROXIMO_ANO->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clddc20$PROXIMO_ANO->sql_record($clddc20$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc20$PROXIMO_ANO->excluir(NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc20$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clddc20$PROXIMO_ANO->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = $clddc30$PROXIMO_ANO->sql_record($clddc30$PROXIMO_ANO->sql_query(NULL,"*",NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']));
    if (pg_num_rows($result) > 0) {
      $clddc30$PROXIMO_ANO->excluir(NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']);
      if ($clddc30$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clddc30$PROXIMO_ANO->erro_msg);
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
      
      $clddc10$PROXIMO_ANO = new cl_ddc10$PROXIMO_ANO();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clddc10$PROXIMO_ANO->si150_tiporegistro                   = 10;
      $clddc10$PROXIMO_ANO->si150_codorgao                       = $sCodorgao;
      $clddc10$PROXIMO_ANO->si150_nroleiautorizacao              = $oDados10->si167_nroleiautorizacao;
      $clddc10$PROXIMO_ANO->si150_dtleiautorizacao               = $oDados10->si167_dtleiautorizacao;
      $clddc10$PROXIMO_ANO->si150_dtpublicacaoleiautorizacao     = $oDados10->si167_dtpublicacaoleiautorizacao;
      $clddc10$PROXIMO_ANO->si150_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc10$PROXIMO_ANO->incluir(null);
      if ($clddc10$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clddc10$PROXIMO_ANO->erro_msg);
      }
      
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clddc20$PROXIMO_ANO = new cl_ddc20$PROXIMO_ANO();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clddc20$PROXIMO_ANO->si153_tiporegistro                     = 20;
      $clddc20$PROXIMO_ANO->si153_codorgao                         = $sCodorgao;
      $clddc20$PROXIMO_ANO->si153_nrocontratodivida                = $oDados20->si167_nrocontratodivida;
      $clddc20$PROXIMO_ANO->si153_dtassinatura                     = $oDados20->si167_dtassinatura;
      $clddc20$PROXIMO_ANO->si153_contratodeclei                   = $oDados20->si167_contratodeclei;
      $clddc20$PROXIMO_ANO->si153_nroleiautorizacao                = $oDados20->si167_nroleiautorizacao;
      $clddc20$PROXIMO_ANO->si153_dtleiautorizacao                 = $oDados20->si167_dtleiautorizacao;
      $clddc20$PROXIMO_ANO->si153_objetocontratodivida             = $oDados20->si167_objetocontratodivida;
      $clddc20$PROXIMO_ANO->si153_especificacaocontratodivida      = $oDados20->si167_especificacaocontratodivida;
      $clddc20$PROXIMO_ANO->si153_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc20$PROXIMO_ANO->incluir(null);
      if ($clddc20$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clddc20$PROXIMO_ANO->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 30
    */
    $sSql       = "select * from dividaconsolidada where si167_mesreferencia = '{$this->sDataFinal['6']}'";
    $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      
      $clddc30$PROXIMO_ANO = new cl_ddc30$PROXIMO_ANO();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      
      $clddc30$PROXIMO_ANO->si154_tiporegistro               = 30;
      $clddc30$PROXIMO_ANO->si154_codorgao                   = $sCodorgao;
      $clddc30$PROXIMO_ANO->si154_nrocontratodivida          = $oDados30->si167_nrocontratodivida;
      $clddc30$PROXIMO_ANO->si154_dtassinatura               = $oDados30->si167_dtassinatura;
      $clddc30$PROXIMO_ANO->si154_tipolancamento             = $oDados30->si167_tipolancamento;
      $clddc30$PROXIMO_ANO->si154_tipodocumentocredor        = $oDados30->si167_tipodocumentocredor;
      $clddc30$PROXIMO_ANO->si154_nrodocumentocredor         = $oDados30->si167_nrodocumentocredor;
      $clddc30$PROXIMO_ANO->si154_justificativacancelamento  = "";
      $clddc30$PROXIMO_ANO->si154_vlsaldoanterior            = $oDados30->si167_vlsaldoanterior;
      $clddc30$PROXIMO_ANO->si154_vlcontratacao              = $oDados30->si167_vlcontratacao;
      $clddc30$PROXIMO_ANO->si154_vlamortizacao              = $oDados30->si167_vlamortizacao;
      $clddc30$PROXIMO_ANO->si154_vlcancelamento             = $oDados30->si167_vlcancelamento;
      $clddc30$PROXIMO_ANO->si154_vlencampacao               = $oDados30->si167_vlencampacao;
      $clddc30$PROXIMO_ANO->si154_vlatualizacao              = $oDados30->si167_vlatualizacao;
      $clddc30$PROXIMO_ANO->si154_vlsaldoatual               = $oDados30->si167_vlsaldoatual;
      $clddc30$PROXIMO_ANO->si154_mes                        = $this->sDataFinal['5'].$this->sDataFinal['6'];
      
      $clddc30$PROXIMO_ANO->incluir(null);
      if ($clddc30$PROXIMO_ANO->erro_status == 0) {
        throw new Exception($clddc30$PROXIMO_ANO->erro_msg);
      }
      
    }
    
    db_fim_transacao();
    
    $oGerarDDC = new GerarDDC();
    $oGerarDDC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDDC->gerarDados();
    
  }
		
}			
