<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("classes/db_parpps102021_classe.php");
require_once ("classes/db_parpps202121_classe.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarPARPPS.model.php");

 /**
  * Projeção Atuarial Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */
class SicomArquivoProjecaoAtuarial extends SicomArquivoBase implements iPadArquivoBaseCSV {
    
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
  protected $sNomeArquivo = 'PARPPS';
  
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
   * selecionar os dados de Projeção Atuarial do RPPS do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {
    
  	$clparpps102021 = new cl_parpps102021();
    $clparpps202121 = new cl_parpps202121();

    db_inicio_transacao();
    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clparpps102021->sql_record($clparpps102021->sql_query(NULL,"*",NULL,"si156_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'].$this->sDataFinal['6']." and si156_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clparpps102021->excluir(NULL,"si156_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'].$this->sDataFinal['6']." and si156_instit = ".db_getsession("DB_instit"));
      if ($clparpps102021->erro_status == 0) {
        throw new Exception($clparpps102021->erro_msg);
      }
    }
    
    /*
     * excluir informacoes do mes selecionado registro 20
     */
    $result = $clparpps202121->sql_record($clparpps202121->sql_query(NULL,"*",NULL,"si155_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'].$this->sDataFinal['6']." and si155_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clparpps202121->excluir(NULL,"si155_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'].$this->sDataFinal['6']." and si155_instit = ".db_getsession("DB_instit"));
      if ($clparpps202121->erro_status == 0) {
        throw new Exception($clparpps202121->erro_msg);
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
    $sSql       = "select * from projecaoatuarial10 where si168_dtcadastro = between '{$this->sDataInicial}' and '{$this->sDataFinal}' and si168_instit = ". db_getsession("DB_instit");
    
    $rsResult10 = db_query($sSql);

    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
      $clparpps102021 = new cl_parpps102021();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);
      
      $clparpps102021->si156_tiporegistro                        = 10;
      $clparpps102021->si156_codorgao                            = $sCodorgao;
      $clparpps102021->si156_vlsaldofinanceiroexercicioanterior  = $oDados10->si168_vlsaldofinanceiroexercicioanterior;
      $clparpps102021->si156_mes                                 = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clparpps102021->si156_instit                              = db_getsession("DB_instit");
      
      $clparpps102021->incluir(null);
      if ($clparpps102021->erro_status == 0) {
        throw new Exception($clparpps102021->erro_msg);
      }
      
    }
    
    /*
     * selecionar informacoes registro 20
     */
    $sSql       = "select * from projecaoatuarial20 where si169_dtcadastro = between '{$this->sDataInicial}' and '{$this->sDataFinal}' and si168_instit = ". db_getsession("DB_instit");
    $rsResult20 = db_query($sSql);
    
    for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {
      
      $clparpps202121 = new cl_parpps202121();
      $oDados20 = db_utils::fieldsMemory($rsResult20, $iCont20);
      
      $clparpps202121->si155_tiporegistro                     = 20;
      $clparpps202121->si155_codorgao                         = $sCodorgao;
      $clparpps202121->si155_exercicio                        = $oDados20->si169_exercicio;
      $clparpps202121->si155_vlreceitaprevidenciaria          = $oDados20->si169_vlreceitaprevidenciaria;
      $clparpps202121->si155_vldespesaprevidenciaria          = $oDados20->si169_vldespesaprevidenciaria;
      $clparpps202121->si155_mes                              = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clparpps202121->si155_instit                           = db_getsession("DB_instit");
      
      $clparpps202121->incluir(null);
      if ($clparpps202121->erro_status == 0) {
        throw new Exception($clparpps202121->erro_msg);
      }

    }

    db_fim_transacao();
    
    $oGerarPARPPS = new GerarPARPPS();
    $oGerarPARPPS->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPARPPS->gerarDados();
    
  }
		
}
