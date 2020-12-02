<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_rec102021_classe.php");
require_once ("classes/db_rec112021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarREC.model.php");

 /**
  * detalhamento das receitas do mês Sicom Acompanhamento Mensal
  * @author robson
  * @package Contabilidade
  */
class SicomArquivoDetalhamentoReceitasMes extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout = 149;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REC';

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

    $aElementos[10] = array(
                          "tipoRegistro",
                          "codReceita",
                          "codOrgao",
                          "identificadorDeducao",
                          "rubrica",
                          "especificacao",
                          "vlArrecadado",
                          "vlAcumuladoMesAnt"
                        );
    $aElementos[11] = array(
                          "tipoRegistro",
                          "codReceita",
                          "codFonte",
                          "vlArrecadadoFonte",
    											"vlAcumuladoFonteMesAnt"
                        );
    return $aElementos;
  }

  /**
   * selecionar os dados das receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {


    /**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
  	 */
  	$clrec102021 = new cl_rec102021();
  	$clrec112021 = new cl_rec112021();

  	$db_filtro  = "o70_instit = ".db_getsession("DB_instit");
    $rsResult10  = db_receitasaldo(11,1,3,true,$db_filtro,db_getsession("DB_anousu"),$this->sDataInicial,$this->sDataFinal,false,' * ',true,0);
    //db_criatabela($rsResult10);
    $sSql = "select si09_codorgaotce from infocomplementaresinstit where si09_instit = ".db_getsession("DB_instit");
    $rsResult = db_query($sSql);
    $sCodOrgaoTce = db_utils::fieldsMemory($rsResult, 0)->si09_codorgaotce;

    /**
     * exlcuir informacoes do mes selecionado
     */
    db_inicio_transacao();

    $result = $clrec112021->sql_record($clrec112021->sql_query(NULL,"*",NULL,"si26_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6'])." and si26_instit = ".db_getsession("DB_instit"));
    if (pg_num_rows($result) > 0) {
    	$clrec112021->excluir(NULL,"si26_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si26_instit = ".db_getsession("DB_instit"));
      if ($clrec112021->erro_status == 0) {
    	  throw new Exception($clrec112021->erro_msg);
      }
    }

    $result = $clrec102021->sql_record($clrec102021->sql_query(NULL,"*",NULL,"si25_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si25_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clrec102021->excluir(NULL,"si25_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si25_instit = ".db_getsession("DB_instit"));
      if ($clrec102021->erro_status == 0) {
    	  throw new Exception($clrec102021->erro_msg);
      }
    }
    /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
    $aRectce = array('111202','111208','172136','191138','191139','191140',
                 '191308','191311','191312','191313','193104','193111',
                 '193112','193113','172401','247199','247299');

    $aDadosAgrupados = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

    	$oDadosRec = db_utils::fieldsMemory($rsResult10, $iCont10);
    	if ($oDadosRec->o70_codigo != 0) {
    	/**
    	 * agrupar registro 10
    	 */
    	if( in_array(substr($oDadosRec->o57_fonte, 1, 6) ,$aRectce ) ) {
        $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 6)."00";
      }else if( substr($oDadosRec->o57_fonte, 0, 2) == '49'  ){
        $sNaturezaReceita = substr($oDadosRec->o57_fonte, 3, 8);
      } else{
        $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
      }
    	$sHash10 = $sNaturezaReceita;
    	if (!isset($aDadosAgrupados[$sHash10])) {

    	  /*if (substr($oDadosRec->o57_fonte, 0, 1) == 49) {
    		  $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
    	  } else
    	  if (substr($oDadosRec->o57_fonte, 0, 1) == 4) {
    		  $sNaturezaReceita = substr($oDadosRec->o57_fonte, 0, 8);
    	  }*/

    	  $oDados10 = new stdClass();
		    $oDados10->si25_tiporegistro         = 10;
		    $oDados10->si25_codreceita           = $oDadosRec->o70_codrec;
		    $oDados10->si25_codorgao             = $sCodOrgaoTce;
		    $oDados10->si25_ededucaodereceita    = $oDadosRec->o70_concarpeculiar != 0 ? 1 : 2;
		    $oDados10->si25_identificadordeducao = substr($oDadosRec->o70_concarpeculiar, -2, 2);
		    $oDados10->si25_naturezareceita      = $sNaturezaReceita;
		    $oDados10->si25_especificacao        = $oDadosRec->o57_descr;
		    $oDados10->si25_vlarrecadado         = 0;
		    $oDados10->si25_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    $oDados10->Reg11                     = array();

		    $aDadosAgrupados[$sHash10] = $oDados10;

    	}
		  $aDadosAgrupados[$sHash10]->si25_vlarrecadado += $oDadosRec->saldo_arrecadado;

		  /**
		   * agrupar registro 11
		   */
    	$sHash11 = $oDadosRec->o57_codigo;
    	if (!isset($aDadosAgrupados[$sHash10]->Reg11[$sHash11])) {


    		$sSql   = "select * from orctiporec where o15_codigo = ".$oDadosRec->o70_codigo;
    		$result = db_query($sSql);
    		$sCodFontRecursos = db_utils::fieldsMemory($result, 0)->o15_codtri;

    		$oDados11 = new stdClass();
    		$oDados11->si26_tiporegistro      = 11;
    		$oDados11->si26_codreceita        = $oDadosRec->o70_codrec;
    		$oDados11->si26_codfontrecursos   = $sCodFontRecursos;
    		$oDados11->si26_vlarrecadadofonte = 0;
    		$oDados11->si26_mes               = $this->sDataFinal['5'].$this->sDataFinal['6'];

    		$aDadosAgrupados[$sHash10]->Reg11[$sHash11] = $oDados11;

    	}
    	$aDadosAgrupados[$sHash10]->Reg11[$sHash11]->si26_vlarrecadadofonte += $oDadosRec->saldo_arrecadado;

    	}

    }

    $aRectceSaudEduc = array('11120101','11120210','11120431','11120434','11120800','11130501','11130502','17210102', '17210105','17213600',
                            '17220101','17220102','17220104','19110801','19113800','19113900','19114000','19130800','19131100','19131200',
                            '19131300','19310400','19311100','19311200','19311300');
    foreach ($aDadosAgrupados as $oDados10) {

    	$clrec102021 = new cl_rec102021();
		  $clrec102021->si25_tiporegistro         = $oDados10->si25_tiporegistro;
		  $clrec102021->si25_codreceita           = $oDados10->si25_codreceita;
		  $clrec102021->si25_codorgao             = $oDados10->si25_codorgao;
		  $clrec102021->si25_ededucaodereceita    = $oDados10->si25_ededucaodereceita;
		  $clrec102021->si25_identificadordeducao = $oDados10->si25_identificadordeducao;
		  $clrec102021->si25_naturezareceita      = $oDados10->si25_naturezareceita;
		  $clrec102021->si25_especificacao        = $oDados10->si25_especificacao;
		  $clrec102021->si25_vlarrecadado         = abs($oDados10->si25_vlarrecadado);
		  $clrec102021->si25_mes                  = $oDados10->si25_mes;
		  $clrec102021->si25_instit               = db_getsession("DB_instit");

		  $clrec102021->incluir(null);
    	if ($clrec102021->erro_status == 0) {
    	  throw new Exception($clrec102021->erro_msg);
      }
      foreach ($oDados10->Reg11 as $oDados11) {
      	if (in_array($oDados10->si25_naturezareceita ,$aRectceSaudEduc )) {
      		if ($oDados11->si26_codfontrecursos == '100') {
      			$nValor = $oDados10->si25_vlarrecadado*0.60;
      		} else if ($oDados11->si26_codfontrecursos == '101') {
      			$nValor = $oDados10->si25_vlarrecadado*0.25;
      		} else if ($oDados11->si26_codfontrecursos == '102') {
      			$nValor = $oDados10->si25_vlarrecadado*0.15;
      		}

      	  $clrec112021 = new cl_rec112021();
    		  $clrec112021->si26_tiporegistro      = $oDados11->si26_tiporegistro;
    		  $clrec112021->si26_reg10             = $clrec102021->si25_sequencial;
    		  $clrec112021->si26_codreceita        = $oDados11->si26_codreceita;
    		  $clrec112021->si26_codfontrecursos   = '100';
    		  $clrec112021->si26_vlarrecadadofonte = abs($oDados10->si25_vlarrecadado*0.60);
    		  $clrec112021->si26_mes               = $oDados11->si26_mes;
    		  $clrec112021->si26_instit            = db_getsession("DB_instit");

          $clrec112021->incluir(null);
    	    if ($clrec112021->erro_status == 0) {
    	      throw new Exception($clrec112021->erro_msg);
          }

          $clrec112021->si26_sequencial = null;
          $clrec112021->si26_codfontrecursos   = '101';
          $clrec112021->si26_vlarrecadadofonte = abs($oDados10->si25_vlarrecadado*0.25);
      	  $clrec112021->incluir(null);
    	    if ($clrec112021->erro_status == 0) {
    	      throw new Exception($clrec112021->erro_msg);
          }

      	  $clrec112021->si26_sequencial = null;
          $clrec112021->si26_codfontrecursos   = '102';
          $clrec112021->si26_vlarrecadadofonte = abs($oDados10->si25_vlarrecadado*0.15);
      	  $clrec112021->incluir(null);
    	    if ($clrec112021->erro_status == 0) {
    	      throw new Exception($clrec112021->erro_msg);
          }

      	} else {

          $clrec112021 = new cl_rec112021();
    		  $clrec112021->si26_tiporegistro      = $oDados11->si26_tiporegistro;
    		  $clrec112021->si26_reg10             = $clrec102021->si25_sequencial;
    		  $clrec112021->si26_codreceita        = $oDados11->si26_codreceita;
    		  $clrec112021->si26_codfontrecursos   = $oDados11->si26_codfontrecursos;
    		  $clrec112021->si26_vlarrecadadofonte = abs($oDados11->si26_vlarrecadadofonte);
    		  $clrec112021->si26_mes               = $oDados11->si26_mes;
    		  $clrec112021->si26_instit            = db_getsession("DB_instit");

          $clrec112021->incluir(null);
    	    if ($clrec112021->erro_status == 0) {
    	      throw new Exception($clrec112021->erro_msg);
          }

      	}

      }


    }

    db_fim_transacao();

    $oGerarREC = new GerarREC();
    $oGerarREC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarREC->gerarDados();

    }

  }
