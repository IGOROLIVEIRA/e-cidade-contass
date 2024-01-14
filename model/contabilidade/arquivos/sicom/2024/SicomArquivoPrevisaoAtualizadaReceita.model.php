<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_parec102024_classe.php");
require_once ("classes/db_parec112024_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarPAREC.model.php");
/**
 *
 * selecionar dados de Previsão Atualizada da Receita
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoPrevisaoAtualizadaReceita extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 * Código do layout. (db_layouttxt.db50_codigo)
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
	 * Código da Pespectiva. (ppaversao.o119_sequencial)
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
   * Gerar os dados necessários para o arquivo
   *
   */
  public function gerarDados(){

   /**
  	 * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
  	 */
  	$clparec102024 = new cl_parec102024();
  	$clparec112024 = new cl_parec112024();

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

    $result = $clparec112024->sql_record($clparec112024->sql_query(NULL,"*",NULL,"si23_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si23_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clparec112024->excluir(NULL,"si23_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si23_instit = ".db_getsession("DB_instit"));
      if ($clparec112024->erro_status == 0) {
    	  throw new Exception($clparec112024->erro_msg);
      }
    }

    $result = $clparec102024->sql_record($clparec102024->sql_query(NULL,"*",NULL,"si22_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si22_instit = ".db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
    	$clparec102024->excluir(NULL,"si22_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." and si22_instit = ".db_getsession("DB_instit"));
      if ($clparec102024->erro_status == 0) {
    	  throw new Exception($clparec102024->erro_msg);
      }
    }

    $aDadosAgrupados = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {


    	$oDadosParec = db_utils::fieldsMemory($rsResult10, $iCont10);
    	if ($oDadosParec->o70_codigo != 0) {
    	/**
    	 * agrupar registro 10
    	 */
    	$sHash10 = $oDadosParec->o57_fonte;
    	if (!isset($aDadosAgrupados[$sHash10])) {

    	  if (substr($oDadosParec->o57_fonte, 0, 1) == 4) {
    		  $sNaturezaReceita = substr($oDadosParec->o57_fonte, 1, 8);
    	  } else {
    		  $sNaturezaReceita = substr($oDadosParec->o57_fonte, 0, 8);
    	  }

    	  $oDados10 = new stdClass();
		    $oDados10->si22_tiporegistro         = 10;
		    $oDados10->si22_codreduzido          = $oDadosParec->o70_codrec;
		    $oDados10->si22_codorgao             = $sCodOrgaoTce;
		    $oDados10->si22_ededucaodereceita    = $oDadosParec->o70_concarpeculiar != 0 ? 1 : 2;
		    $oDados10->si22_identificadordeducao = substr($oDadosParec->o70_concarpeculiar, -2, 2);
		    $oDados10->si22_naturezareceita      = $sNaturezaReceita;
		    $oDados10->si22_tipoatualizacao      = 1;
		    $oDados10->si22_especificacao        = $oDadosParec->o57_descr;
		    $oDados10->si22_vlacrescidoreduzido  = 0;//$oDadosParec->saldo_prevadic_acum;
		    $oDados10->si22_mes                  = $this->sDataFinal['5'].$this->sDataFinal['6'];
		    $oDados10->Reg11                     = array();

		    $aDadosAgrupados[$sHash10] = $oDados10;

    	}
		  $aDadosAgrupados[$sHash10]->si22_vlacrescidoreduzido += $oDadosParec->saldo_prevadic_acum;

		  /**
		   * agrupar registro 11
		   */
    	$sHash11 = $oDadosParec->o57_codigo;
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
    	$aDadosAgrupados[$sHash10]->Reg11[$sHash11]->si23_vlfonte += $oDadosParec->saldo_prevadic_acum;

    	}
    }

    foreach ($aDadosAgrupados as $oDados10) {

    	$clparec102024 = new cl_parec102024();
		  $clparec102024->si22_tiporegistro         = $oDados10->si22_tiporegistro;
		  $clparec102024->si22_codreduzido          = $oDados10->si22_codreduzido;
		  $clparec102024->si22_codorgao             = $oDados10->si22_codorgao;
		  $clparec102024->si22_ededucaodereceita    = $oDados10->si22_ededucaodereceita;
		  $clparec102024->si22_identificadordeducao = $oDados10->si22_identificadordeducao;
		  $clparec102024->si22_naturezareceita      = $oDados10->si22_naturezareceita;
		  $clparec102024->si22_tipoatualizacao      = $oDados10->si22_tipoatualizacao;
		  $clparec102024->si22_especificacao        = $oDados10->si22_especificacao;
		  $clparec102024->si22_vlacrescidoreduzido  = abs($oDados10->si22_vlacrescidoreduzido);
		  $clparec102024->si22_mes                  = $oDados10->si22_mes;
		  $clparec102024->si22_instit               = db_getsession("DB_instit");

		  $clparec102024->incluir(null);
    	if ($clparec102024->erro_status == 0) {
    	  throw new Exception($clparec102024->erro_msg);
      }
      foreach ($oDados10->Reg11 as $oDados11) {

        $clparec112024 = new cl_parec112024();
    		$clparec112024->si23_tiporegistro    = $oDados11->si23_tiporegistro;
    		$clparec112024->si23_codreduzido     = $oDados11->si23_codreduzido;
    		$clparec112024->si23_codfontrecursos = $oDados11->si23_codfontrecursos;
    		$clparec112024->si23_vlfonte         = abs($oDados11->si23_vlfonte);
    		$clparec112024->si23_mes             = $oDados11->si23_mes;
    		$clparec112024->si23_reg10           = $clparec102024->si22_sequencial;
    		$clparec112024->si23_instit          = db_getsession("DB_instit");

        $clparec112024->incluir(null);
    	  if ($clparec112024->erro_status == 0) {
    	    throw new Exception($clparec112024->erro_msg);
        }

      }


    }

    db_fim_transacao();

    $oGerarPAREC = new GerarPAREC();
    $oGerarPAREC->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarPAREC->gerarDados();

  }

}
