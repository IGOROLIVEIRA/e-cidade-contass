<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_dclrf102015_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2015/GerarDCLRF.model.php");

 /**
  * Dados Complementares Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoDadosComplementares extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
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
  protected $sNomeArquivo = 'DCLRF';
  
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
   * selecionar os dados de Dados Complementares � LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$cldclrf10 = new cl_dclrf102015();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $cldclrf10->sql_record($cldclrf10->sql_query(NULL,"*",NULL,"si157_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si157_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $cldclrf10->excluir(NULL,"si157_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si157_instit = ".db_getsession("DB_instit"));
      if ($cldclrf10->erro_status == 0) {
        throw new Exception($cldclrf10->erro_msg);
      }
    }

    
    $sSql  = "SELECT si09_codorgaotce AS codorgao, si09_tipoinstit AS tipoinstit
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");
      
    $rsResult    = db_query($sSql);
    $sCodorgao   = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    
    /*
     * selecionar informacoes registro 10
     */

        $sSql       = "select * from dadoscomplementareslrf where si170_mesreferencia = '{$this->sDataFinal['6']}' and si170_instit = ". db_getsession("DB_instit");
        
        $rsResult10 = db_query($sSql);

        for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
          
          $cldclrf10 = new cl_dclrf102015();
          $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
          
          $cldclrf10->si157_tiporegistro                        = 10;
          $cldclrf10->si157_codorgao                            = $sCodorgao;
          $cldclrf10->si157_vlsaldoatualconcgarantia            = $oDados10->si170_vlsaldoatualconcgarantia;
          $cldclrf10->si157_recprivatizacao                     = $oDados10->si170_recprivatizacao;
          $cldclrf10->si157_vlliqincentcontrib                  = $oDados10->si170_vlliqincentcontrib;
          $cldclrf10->si157_vlliqincentinstfinanc               = $oDados10->si170_vlliqincentInstfinanc;
          $cldclrf10->si157_vlirpnpincentcontrib                = $oDados10->si170_vlIrpnpincentcontrib;
          $cldclrf10->si157_vlirpnpincentinstfinanc             = $oDados10->si170_vllrpnpincentinstfinanc;
          $cldclrf10->si157_vlcompromissado                     = $oDados10->si170_vlcompromissado;
          $cldclrf10->si157_vlrecursosnaoaplicados              = $oDados10->si170_vlrecursosnaoaplicados;
          $cldclrf10->si157_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
          $cldclrf10->si157_instit                              = db_getsession("DB_instit");
          
          $cldclrf10->incluir(null);
          if ($cldclrf10->erro_status == 0) {
            throw new Exception($cldclrf10->erro_msg);
          }
          
        }

    db_fim_transacao();
    
    $oGerarDCLRF = new GerarDCLRF();
    $oGerarDCLRF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDCLRF->gerarDados();
    
  }

}
