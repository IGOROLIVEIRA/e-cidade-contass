<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_ddc102015_classe.php");
require_once ("classes/db_ddc202015_classe.php");
require_once ("classes/db_ddc302015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarDDC.model.php");

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
    
    $clddc10 = new cl_ddc102015();
    $clddc20 = new cl_ddc202015();
    $clddc30 = new cl_ddc302015();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = db_query($clddc10->sql_query(NULL,"*",NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si150_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc10->excluir(NULL,"si150_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si150_instit = ".db_getsession("DB_instit"));
      if ($clddc10->erro_status == 0) {
        throw new Exception($clddc10->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = db_query($clddc20->sql_query(NULL,"*",NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si153_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc20->excluir(NULL,"si153_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si153_instit = ".db_getsession("DB_instit"));
      if ($clddc20->erro_status == 0) {
        throw new Exception($clddc20->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 30
     */
    $result = db_query($clddc30->sql_query(NULL,"*",NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si154_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clddc30->excluir(NULL,"si154_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si154_instit = ".db_getsession("DB_instit"));
      if ($clddc30->erro_status == 0) {
        throw new Exception($clddc30->erro_msg);
      }
    }
    
    db_fim_transacao();
    db_inicio_transacao();
    
    $sSql  = "SELECT si09_codorgaotce AS codorgao
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult  = db_query($sSql);
    $sCodorgao = db_utils::fieldsMemory($rsResult, 0)->codorgao;
      
    /*
     * selecionar informacoes registro 10
     */
    $sSql = "select * from dividaconsolidada where si167_mesreferencia = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
             and si167_anoreferencia = ".db_getsession("DB_anousu")." and si167_instit = ".db_getsession("DB_instit")." and not exists
             (select 1 from ddc102015  where si150_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6']."  and si150_instit = ".db_getsession("DB_instit")."
             and si150_nroleiautorizacao = si167_nroleiautorizacao and si150_dtleiautorizacao = si167_dtleiautorizacao
              union select 1 from ddc102014  where si150_nroleiautorizacao = si167_nroleiautorizacao and si150_dtleiautorizacao = si167_dtleiautorizacao
              and si150_instit = ".db_getsession("DB_instit").")";
    
    $rsResult10 = db_query($sSql);
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clddc10 = new cl_ddc102015();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clddc10->si150_tiporegistro                   = 10;
      $clddc10->si150_codorgao                       = $sCodorgao;
      $clddc10->si150_nroleiautorizacao              = $oDados10->si167_nroleiautorizacao;
      $clddc10->si150_dtleiautorizacao               = $oDados10->si167_dtleiautorizacao;
      $clddc10->si150_dtpublicacaoleiautorizacao     = $oDados10->si167_dtpublicacaoleiautorizacao;
      $clddc10->si150_mes                            = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clddc10->si150_instit                         = db_getsession("DB_instit");
      
      $clddc10->incluir(null);
      if ($clddc10->erro_status == 0) {
        throw new Exception($clddc10->erro_msg);
      }
      
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql = "select * from dividaconsolidada where si167_mesreferencia = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
             and si167_anoreferencia = ".db_getsession("DB_anousu")." and si167_instit = ".db_getsession("DB_instit")." and not exists
             (select 1 from ddc202015  where si153_mes < ".$this->sDataFinal['5'].$this->sDataFinal['6']."  and si153_instit = ".db_getsession("DB_instit")."
             and si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              union select 1 from ddc202014  where si153_nrocontratodivida = si167_nrocontratodivida and si153_dtassinatura = si167_dtassinatura
              and si153_instit = ".db_getsession("DB_instit").")";
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clddc20 = new cl_ddc202015();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clddc20->si153_tiporegistro                     = 20;
      $clddc20->si153_codorgao                         = $sCodorgao;
      $clddc20->si153_nrocontratodivida                = $oDados20->si167_nrocontratodivida;
      $clddc20->si153_dtassinatura                     = $oDados20->si167_dtassinatura;
      $clddc20->si153_contratodeclei                   = $oDados20->si167_contratodeclei;
      $clddc20->si153_nroleiautorizacao                = $oDados20->si167_nroleiautorizacao;
      $clddc20->si153_dtleiautorizacao                 = $oDados20->si167_dtleiautorizacao;
      $clddc20->si153_objetocontratodivida             = $this->removeCaracteres($oDados20->si167_objetocontratodivida);
      $clddc20->si153_especificacaocontratodivida      = $this->removeCaracteres($oDados20->si167_especificacaocontratodivida);
      $clddc20->si153_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clddc20->si153_instit                           = db_getsession("DB_instit");
      
      $clddc20->incluir(null);
      if ($clddc20->erro_status == 0) {
        throw new Exception($clddc20->erro_msg);
      }

    }

    /*
    * selecionar informacoes registro 30
    */
    $sSql = "select * from dividaconsolidada
             inner join cgm on z01_numcgm = si167_numcgm
             where si167_mesreferencia = ".$this->sDataFinal['5'].$this->sDataFinal['6']."
             and si167_anoreferencia = ".db_getsession("DB_anousu")." and si167_instit = ".db_getsession("DB_instit");
    $rsResult30 = db_query($sSql);
    for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {
      
      $clddc30 = new cl_ddc302015();
      $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);
      
      $clddc30->si154_tiporegistro               = 30;
      $clddc30->si154_codorgao                   = $sCodorgao;
      $clddc30->si154_nrocontratodivida          = $oDados30->si167_nrocontratodivida;
      $clddc30->si154_dtassinatura               = $oDados30->si167_dtassinatura;
      $clddc30->si154_tipolancamento             = $oDados30->si167_tipolancamento;
      $clddc30->si154_tipodocumentocredor        = (strlen($oDados30->z01_cgccpf) == 11)? 1 : 2;
      $clddc30->si154_nrodocumentocredor         = $oDados30->z01_cgccpf;
      $clddc30->si154_justificativacancelamento  = ($oDados30->si167_justificativacancelamento == null || $oDados30->si167_justificativacancelamento == "")? "": $oDados30->si167_justificativacancelamento;
      $clddc30->si154_vlsaldoanterior            = $oDados30->si167_vlsaldoanterior;
      $clddc30->si154_vlcontratacao              = $oDados30->si167_vlcontratacao;
      $clddc30->si154_vlamortizacao              = $oDados30->si167_vlamortizacao;
      $clddc30->si154_vlcancelamento             = $oDados30->si167_vlcancelamento;
      $clddc30->si154_vlencampacao               = $oDados30->si167_vlencampacao;
      $clddc30->si154_vlatualizacao              = $oDados30->si167_vlatualizacao;
      $clddc30->si154_vlsaldoatual               = $oDados30->si167_vlsaldoatual;
      $clddc30->si154_mes                        = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clddc30->si154_instit                     = db_getsession("DB_instit");
      
      $clddc30->incluir(null);
      if ($clddc30->erro_status == 0) {
        throw new Exception($clddc30->erro_msg);
      }
      
    }

    db_fim_transacao();
    
    $oGerarDDC = new GerarDDC();
    $oGerarDDC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDDC->gerarDados();
    
  }
		
}			