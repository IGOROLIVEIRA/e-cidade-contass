<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_parec102014_classe.php");
require_once ("classes/db_parec112014_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2014/GerarPAREC.model.php");
/**
 * 
 * selecionar dados de Previs�o Atualizada da Receita
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoPrevisaoAtualizadaReceita extends SicomArquivoBase implements iPadArquivoBaseCSV {
  
	/**
	 * C�digo do layout. (db_layouttxt.db50_codigo)
	 *
	 * @var Integer
	 */
  protected $iCodigoLayout = 194;

  /**
	 * Nome do arquivo a ser criado
	 *
	 * @var String
	 */
  protected $sNomeArquivo = 'PAREC';
  
  /**
	 * C�digo da Pespectiva. (ppaversao.o119_sequencial)
	 *
	 * @var Integer
	 */
  protected $iCodigoPespectiva;
  
  /**
   * 
   * Construtor da classe
   */
  public function __construct() {
    
  }
  
  /**
   * retornar o codio do layout
   * 
   *@return Integer
   */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV 
   *
   *@return Array
   */
  public function getCampos(){
    
    $aElementos[10] = array(
                          "tipoRegistro",
    											"codReceita",
                          "codOrgao",
    											"identificadorDeducao",
    											"rubrica",
    											"tipoAtualizacao",
    											"especificacao",
    											"vlPrevisto"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
    											"codReceita",
    											"codFonte",
    											"vlFonte"
                        );
    return $aElementos;
  }
  
  /**
   * Gerar os dados necess�rios para o arquivo
   *
   */
  public function gerarDados(){
  	
   /**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo 
  	 */
  	$clparec102014 = new cl_parec102014();
  	$clparec112014 = new cl_parec112014();

  	$db_filtro  = "o70_instit = ".db_getsession("DB_instit");
    $rsResult10  = db_receitasaldo(11,1,3,true,$db_filtro,db_getsession("DB_anousu"),$this->sDataInicial,$this->sDataFinal,false,' * ',true,0);
    //db_criatabela($rsResult10);
    $sSql   = "SELECT * FROM infocomplementaresinstit WHERE si09_tipoinstit != 2 and si09_instit = ".db_getsession("DB_instit");
    $rsPref = db_query($sSql);
    if (pg_num_rows($rsPref) > 0) {
    	$rsResult10 = 0;
    }
    
    $sSql = "select si09_codorgaotce from infocomplementaresinstit where si09_instit = ".db_getsession("DB_instit");
    $rsResult = db_query($sSql);
    $sCodOrgaoTce = db_utils::fieldsMemory($rsResult, 0)->si09_codorgaotce;
    
    /**
     * exlcuir informacoes do mes selecionado
     */
    db_inicio_transacao();
    
    $result = $clparec112014->sql_record($clparec112014->sql_query(NULL,"*",NULL,"si23_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si23_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clparec112014->excluir(NULL,"si23_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si23_instit = ".db_getsession("DB_instit"));
      if ($clparec112014->erro_status == 0) {
    	  throw new Exception($clparec112014->erro_msg);
      }
    }
    
    $result = $clparec102014->sql_record($clparec102014->sql_query(NULL,"*",NULL,"si22_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si22_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clparec102014->excluir(NULL,"si22_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si22_instit = ".db_getsession("DB_instit"));
      if ($clparec102014->erro_status == 0) {
    	  throw new Exception($clparec102014->erro_msg);
      }
    }
    /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
    $aRectce = array('111202','111208','172136','191138','191139','191140',
                 '191308','191311','191312','191313','193104','193111',
                 '193112','193113','172401','247199','247299');
    
    $aDadosAgrupados = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {
      
    	
    	$oDadosParec = db_utils::fieldsMemory($rsResult10, $iCont10);
    	if ($oDadosParec->o70_codigo != 0 && $oDadosParec->saldo_inicial_prevadic != 0) { 
    	/**
    	 * agrupar registro 10
    	 */
    	if( in_array(substr($oDadosParec->o57_fonte, 1, 6) ,$aRectce ) ) {
        $sNaturezaReceita = substr($oDadosParec->o57_fonte, 1, 6)."00";
      }else if( substr($oDadosParec->o57_fonte, 0, 2) == '49'  ){
        $sNaturezaReceita = substr($oDadosParec->o57_fonte, 3, 8);
      } else{
        $sNaturezaReceita = substr($oDadosParec->o57_fonte, 1, 8);
      }
    	$sHash10 = $sNaturezaReceita;
    	if (!isset($aDadosAgrupados[$sHash10])) {
    		
    	  /*if (substr($oDadosParec->o57_fonte, 0, 1) == 4) {
    		  $sNaturezaReceita = substr($oDadosParec->o57_fonte, 1, 8);
    	  } else {
    		  $sNaturezaReceita = substr($oDadosParec->o57_fonte, 0, 8);
    	  }*/
    	
    	  $oDados10 = new stdClass();
		    $oDados10->si22_tiporegistro         = 10;
		    $oDados10->si22_codreduzido          = $oDadosParec->o70_codrec;
		    $oDados10->si22_codorgao             = $sCodOrgaoTce;
		    $oDados10->si22_ededucaodereceita    = $oDadosParec->o70_concarpeculiar != 0 ? 1 : 2;
		    $oDados10->si22_identificadordeducao = $oDadosParec->o70_concarpeculiar != 0 ? substr($oDadosParec->o70_concarpeculiar, -2, 2) : '';
		    $oDados10->si22_naturezareceita      = $sNaturezaReceita;
		    $oDados10->si22_tipoatualizacao      = 1;
		    $oDados10->si22_especificacao        = $oDadosParec->o57_descr;
		    $oDados10->si22_vlacrescidoreduzido  = 0;
		    $oDados10->si22_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    $oDados10->Reg11                     = array();
		    
		    $aDadosAgrupados[$sHash10] = $oDados10;
		    
    	}
		  $aDadosAgrupados[$sHash10]->si22_vlacrescidoreduzido += $oDadosParec->saldo_inicial_prevadic;
		  
		  /**
		   * agrupar registro 11
		   */
    	$sHash11 = $oDadosParec->o70_codigo;
    	if (!isset($aDadosAgrupados[$sHash10]->Reg11[$sHash11])) {
    		
    		$sSql   = "select * from orctiporec where o15_codigo = ".$oDadosParec->o70_codigo;
    		$result = db_query($sSql);//echo $sSql."<br>";
    		$sCodFontRecursos = db_utils::fieldsMemory($result, 0)->o15_codtri;
    		
    		$oDados11 = new stdClass();
    		$oDados11->si23_tiporegistro    = 11;
    		$oDados11->si23_codreduzido     = $oDadosParec->o70_codrec;
    		$oDados11->si23_codfontrecursos = $sCodFontRecursos;
    		$oDados11->si23_vlfonte         = 0;
    		$oDados11->si23_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
    		
    		$aDadosAgrupados[$sHash10]->Reg11[$sHash11] = $oDados11;
    		
    	}
    	$aDadosAgrupados[$sHash10]->Reg11[$sHash11]->si23_vlfonte += $oDadosParec->saldo_inicial_prevadic;
		  
    	}
    }
   
    $aRectceSaudEduc = array('11120101','11120200','11120431','11120434','11120800','11130501','11130502','17210102', '17210105','17213600',
                            '17220101','17220102','17220104','19110801','19113800','19113900','19114000','19130800','19131100','19131200',
                            '19131300','19310400','19311100','19311200','19311300');
    foreach ($aDadosAgrupados as $oDados10) {
    	
    	$clparec102014 = new cl_parec102014();
		  $clparec102014->si22_tiporegistro         = $oDados10->si22_tiporegistro;
		  $clparec102014->si22_codreduzido          = $oDados10->si22_codreduzido;
		  $clparec102014->si22_codorgao             = $oDados10->si22_codorgao;
		  $clparec102014->si22_ededucaodereceita    = $oDados10->si22_ededucaodereceita;
		  $clparec102014->si22_identificadordeducao = $oDados10->si22_identificadordeducao;
		  $clparec102014->si22_naturezareceita      = $oDados10->si22_naturezareceita;
		  $clparec102014->si22_tipoatualizacao      = $oDados10->si22_tipoatualizacao;
		  $clparec102014->si22_especificacao        = $this->removeCaracteres($oDados10->si22_especificacao);
		  $clparec102014->si22_vlacrescidoreduzido  = abs($oDados10->si22_vlacrescidoreduzido);
		  $clparec102014->si22_mes                  = $oDados10->si22_mes;
		  $clparec102014->si22_instit               = db_getsession("DB_instit");
		  
		  $clparec102014->incluir(null);
    	if ($clparec102014->erro_status == 0) {
    	  throw new Exception($clparec102014->erro_msg);
      }
      foreach ($oDados10->Reg11 as $oDados11) {
      	
      	if (in_array($oDados10->si22_naturezareceita ,$aRectceSaudEduc ) && 
      	($oDados10->si22_identificadordeducao == 0 || $oDados10->si22_identificadordeducao == '') &&
      	($oDados11->si23_codfontrecursos != '101') && ($oDados11->si23_codfontrecursos != '102')) {

      	  $clparec112014 = new cl_parec112014();
    		  $clparec112014->si23_tiporegistro      = $oDados11->si23_tiporegistro;
    		  $clparec112014->si23_reg10             = $clparec102014->si22_sequencial;
    		  $clparec112014->si23_codreduzido       = $oDados10->si22_codreduzido;
    		  $clparec112014->si23_codfontrecursos   = '100';
    		  $clparec112014->si23_vlfonte           = number_format(abs($oDados10->si22_vlacrescidoreduzido*0.60), 2, ".", "");
    		  $clparec112014->si23_mes               = $oDados11->si23_mes;
    		  $clparec112014->si23_instit            = db_getsession("DB_instit");
    		
          $clparec112014->incluir(null);
    	    if ($clparec112014->erro_status == 0) {
    	      throw new Exception($clparec112014->erro_msg);
          }
          
          $clparec112014->si23_sequencial = null;
          $clparec112014->si23_codfontrecursos   = '101';
          $clparec112014->si23_vlfonte = number_format(abs($oDados10->si22_vlacrescidoreduzido*0.25), 2, ".", "");
      	  $clparec112014->incluir(null);
    	    if ($clparec112014->erro_status == 0) {
    	      throw new Exception($clparec112014->erro_msg);
          }
          
      	  $clparec112014->si23_sequencial = null;
          $clparec112014->si23_codfontrecursos   = '102';
          $clparec112014->si23_vlfonte = number_format(abs($oDados10->si22_vlacrescidoreduzido), 2, ".", "")-(number_format(abs($oDados10->si22_vlacrescidoreduzido*0.60), 2, ".", "")+number_format(abs($oDados10->si22_vlacrescidoreduzido*0.25), 2, ".", ""));
      	  $clparec112014->incluir(null);
    	    if ($clparec112014->erro_status == 0) {
    	      throw new Exception($clparec112014->erro_msg);
          }
      		break;
      	} else if (!in_array($oDados10->si22_naturezareceita ,$aRectceSaudEduc ) || $oDados10->si22_identificadordeducao != 0 
      	             || $oDados10->si22_identificadordeducao == '') {
      	
          $clparec112014 = new cl_parec112014();
    		  $clparec112014->si23_tiporegistro    = $oDados11->si23_tiporegistro;
    		  $clparec112014->si23_codreduzido     = $oDados10->si22_codreduzido;
    		  $clparec112014->si23_codfontrecursos = $oDados11->si23_codfontrecursos;
    		  $clparec112014->si23_vlfonte         = abs($oDados11->si23_vlfonte);
    		  $clparec112014->si23_mes             = $oDados11->si23_mes;
    		  $clparec112014->si23_reg10           = $clparec102014->si22_sequencial;
    		  $clparec112014->si23_instit          = db_getsession("DB_instit");
    		
          $clparec112014->incluir(null);
    	    if ($clparec112014->erro_status == 0) {
    	      throw new Exception($clparec112014->erro_msg);
          }
        
      	}
      	
      }
      
		  
    }
    
    db_fim_transacao();
    
    $oGerarPAREC = new GerarPAREC();
    $oGerarPAREC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPAREC->gerarDados();
  	
  }
  
}
