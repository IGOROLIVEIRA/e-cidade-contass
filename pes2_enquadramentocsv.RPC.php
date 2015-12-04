<?
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("model/pessoal/relatorios/RelatorioEnquadramento.model.php");

$oJson               = new services_json();
$oParam              = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

$oParam->sFolha = 'r53';
$oParam->sAnsin = 'a';
$oParam->sReg = '0';

//print_r($oParam);exit;


$oRetorno            = new stdClass();
$oRetorno->status    = 1;
$oRetorno->message   = 1;
$lErro               = false;
$sMensagem           = "";

$oDadosCsv           = new  RelatorioEnquadramento();
$aRubricas           = array();
$iTipoFolha          = "";
$iAgrupador          = "";
$aSelecionados       = "";


try {

switch($oParam->exec) {
	
	case 'gerarCsv' :
		
		$aRubricasFamilia = array( '0014'  ,
															 'R918'  ,
															 'R920'  ,
															 'R921'  ,
															 'R917'  ,
															 'R917'  ,
															 'R919'  ,
															 'R920'  ,
															 'R921'  ,
															 '0159'  ,
															 '0419'  ,
															 '0130'  ,
															 '0143'  ,
															 'R919'  ,
															 'R918'  
		);

		$aRubricaPrevidencia = array("R993");
		$aRubricasIrrf       = array("R913", "R914", "R915");

		$sCampos  = "distinct rhpessoal.* ";


		if($oParam->sFaixareg != ""){
		   
		  $oDadosCsv->setFiltroAgrupador(explode(",", $oParam->sFaixareg));
		}elseif($oParam->sFaixalot != ""){
		   
		  $oDadosCsv->setFiltroAgrupador(explode(",", $oParam->sFaixalot));
		}elseif($oParam->sFaixaloc != ""){
		   
		  $oDadosCsv->setFiltroAgrupador(explode(",", $oParam->sFaixaloc));
		}elseif($oParam->sFaixaorg != ""){
		   
		  $oDadosCsv->setFiltroAgrupador(explode(",", $oParam->sFaixaorg));
		}elseif(!empty($oParam->iRegini) && !(empty($oParam->iRegfim))) {
		   
		  $oDadosCsv->setFiltroAgrupador($oParam->iRegini, $oParam->iRegfim);
		}elseif (!empty($oParam->iLotini) && !(empty($oParam->iLotfim))){
		   
		  $oDadosCsv->setFiltroAgrupador($oParam->iLotini, $oParam->iLotfim);
		}elseif (!empty($oParam->iLocini) && !(empty($oParam->iLocfim))){
		   
		  $oDadosCsv->setFiltroAgrupador($oParam->iLocini, $oParam->iLocfim);
		}elseif (!empty($oParam->iOrgini) && !(empty($oParam->iOrgfim))){
		   
		  $oDadosCsv->setFiltroAgrupador($oParam->iOrgini, $oParam->iOrgfim);
		}
		
		/**
		 * convertemos o tipo de ponto de string para inteiro para
		 * melhor manipulação
		 */
		switch ($oParam->sFolha){
		  case "r14":
		    $iTipoFolha = "1"; //salario
		    break;
		  case "r48":
		    $iTipoFolha = "2"; //complementar
		    break;
		  case "r20":
		    $iTipoFolha = "3"; //rescisao
		    break;
		  case "r35":
		    $iTipoFolha = "4"; //13 salario
		    break;
		  case "r22":
		    $iTipoFolha = "5"; //adiantamento
		    break;
		  case "r53":
		    $iTipoFolha = "7"; //Ponto Fixo
		    break;
		}
		/**
		 * convertemos o tip de agrupador de string para inteiro para
		 * melhor manipulação
		 */
		switch ($oParam->sTipo){
		  case "g":
		    $iAgrupador = "0"; //Geral
		    break;
		     
		  case "l":
		    $iAgrupador = "1"; //Lotação
		    break;

		  case "o":
		    $iAgrupador = "2"; //Órgão
		    break;

		  case "m":
		    $iAgrupador = "3"; //Matrícula
		    break;

		  case "t":
		    $iAgrupador = "4"; //Locais de trabalho
		    break;
		     
		}

		if($oParam->sAfastado == 'n'){
		  $oDadosCsv->setAfastados(false);
		}
		
		$oDadosCsv->addTipoFolha   ($iTipoFolha  );
		$oDadosCsv->setAgrupador   ($iAgrupador  );
		$oDadosCsv->setCompetencia ($oParam->iMes, $oParam->iAno);
		$oDadosCsv->setSelecao     ($oParam->sSel);
		//$oDadosCsv->setRegime      ($oParam->sReg);
		$oDadosCsv->setCamposQuery ($sCampos     );


		/*if($iTipoFolha == "2"){
		  
		  // setamos o ponto complementar
		  $oDadosCsv->setCodigoComplementar($oParam->sSemest);
		}*/

		$aDadosCsv          = $oDadosCsv->getDadosBase();
		
		$aDadosCsvServidor  = $aDadosCsv->aDadosServidor;
		$aDadosCsvRubricas  = $aDadosCsv->aDadosRubricas;
		$aDadosRubricas     = $aDadosCsv->aRubricas;
		$iDadosRelatorio    = count($aDadosRubricas);

		//print_r($aDadosCsvRubricas);exit;
		
		
		if($iDadosRelatorio == 0){
		  throw new Exception("Nenhum registro Encontrado");
		}

		$sArquivo     = "tmp/relatorioEnquadramento.csv";
		
		$fArquivo     = fopen($sArquivo, "w");

		$aDadosRelatorio["iMatricula"]            = "Matrícula";
		$aDadosRelatorio["sNome"]                 = "Nome";
		$aDadosRelatorio["sLotacao"]              = "Lotação";
		$aDadosRelatorio["sCargo"]                = "Cargo";
		$aDadosRelatorio["sAdmissao"]             = "Data Admissao";
		$aDadosRelatorio["sRegime"]             	= "Regime";
		$aDadosRelatorio["sHora"]                 = "Horas Mensais";
		
		if ( $oParam->sAnsin == 'a' ) {

		  foreach ( $aDadosRubricas as $oRubrica ) {

		    $aDadosRelatorio["quant_{$oRubrica->rubrica}"] = "Quant_{$oRubrica->rubrica}";
		    $aDadosRelatorio["valor_{$oRubrica->rubrica}"] = "Valor_{$oRubrica->rubrica}";
		  }
		} else {

		  $aDadosRelatorio["nPrevidenciaSintetico"] = "Previdência";
		  $aDadosRelatorio["nIrrfSintetico"]        = "I.R.R.F";
		  $aDadosRelatorio["nSalFamiliaSintetico"]  = "Sal.Familía";
		}

		//$aDadosRelatorio["nProventoSintetico"]    = "Proventos";
		//$aDadosRelatorio["nDescontoSintetico"]    = "Descontos";
		//$aDadosRelatorio["nLiquidoSintetico"]     = "Liquido";

		fputcsv($fArquivo, $aDadosRelatorio, ";");
		
		/**
		 * Percorre os dados referentes ao servidor
		 */
		foreach ($aDadosCsvServidor as $iMatricula => $oDadosServidor)	{
		   
		  $aDadosRelatorio["iMatricula"]             = $oDadosServidor->matricula_servidor;
		  $aDadosRelatorio["sNome"]                  = $oDadosServidor->nome_servidor;
		  $aDadosRelatorio["sLotacao"]               = $oDadosServidor->codigo_lotacao." - ".$oDadosServidor->descr_lotacao;
		  $aDadosRelatorio["sCargo"]                 = $oDadosServidor->codigo_cargo  ." - ".$oDadosServidor->descr_cargo;
		  $aDadosRelatorio["sCargo"]                 = $oDadosServidor->codigo_cargo  ." - ".$oDadosServidor->descr_cargo;
		  $aDadosRelatorio["sAdmissao"]              = $oDadosServidor->data_admissao;
		  $aDadosRelatorio["sRegime"]                = $oDadosServidor->descr_regime;
		  $aDadosRelatorio["sHora"]                  = $oDadosServidor->horas_mensais;
		  
		  if ($oParam->sAnsin == 'a') {

		    foreach ($aDadosRubricas as $oRubrica){
		      $aDadosRelatorio["quant_{$oRubrica->rubrica}"]  = 0;
		      $aDadosRelatorio["valor_{$oRubrica->rubrica}"]  = 0;
		    }
		  } else {
		    
		    $aDadosRelatorio["nPrevidenciaSintetico"]  = 0;
		    $aDadosRelatorio["nIrrfSintetico"]         = 0;
		    $aDadosRelatorio["nSalFamiliaSintetico"]   = 0;
		  }
		  
		  //$aDadosRelatorio["nProventoSintetico"]     = 0;
		  //$aDadosRelatorio["nDescontoSintetico"]     = 0;
		  //$aDadosRelatorio["nLiquidoSintetico"]      = 0;

		  /**
		   * Percorre os dados referentes a folha de pagamento escolhida
		   */
		  foreach ($aDadosCsvRubricas as $sTabelaPonto => $aDadosRubricaFolha) {
		    /**
		     * Percorre as matriculas do servidor selecionado
		     */
		    foreach ($aDadosRubricaFolha[$iMatricula] as $oDadosRubricasSintetico) {
		      /**
		       * Valida se o valor vai ser adiconado a provento ou desconto
		       */
		      switch ($oDadosRubricasSintetico->provento_desconto){
		        case "1":
		          $aDadosRelatorio["nProventoSintetico"]  += $oDadosRubricasSintetico->valor_rubrica;
		          //$aDadosRelatorio["nProventoSintetico"]   = number_format($aDadosRelatorio["nProventoSintetico"], 2, ",", "");
		          break;
		        case "2" :
		          $aDadosRelatorio["nDescontoSintetico"]  += $oDadosRubricasSintetico->valor_rubrica;
		          //$aDadosRelatorio["nDescontoSintetico"]   = number_format($aDadosRelatorio["nDescontoSintetico"], 2, ",", "");
		          break;
		      }
		      /**
		       * Caso seja um relatório analítico mostra em detalhe os valores das rubricas
		       */
		      if ($oParam->sAnsin == 'a') {
		         
		        if ( isset( $aDadosRubricas[$oDadosRubricasSintetico->rubrica] ) ) {
		          
		          $aDadosRelatorio["quant_{$oDadosRubricasSintetico->rubrica}"] = number_format($oDadosRubricasSintetico->quant_rubrica, 2, ",", "");
		          $aDadosRelatorio["valor_{$oDadosRubricasSintetico->rubrica}"] = number_format($oDadosRubricasSintetico->valor_rubrica, 2, ",", "");
		        } else {
		          $aDadosRelatorio["quant_{$oDadosRubricasSintetico->rubrica}"] = "0,00";
		          $aDadosRelatorio["valor_{$oDadosRubricasSintetico->rubrica}"] = "0,00";
		        }
		      } else {
		        /**
		         * somamos todas rubricas referente a salario familia, que estiverem no array
		         */
		        if(in_array($oDadosRubricasSintetico->rubrica, $aRubricasFamilia)){
		          $aDadosRelatorio["nSalFamiliaSintetico"]   += $oDadosRubricasSintetico->valor_rubrica;
		        }
		        /**
		         * somamos todas rubricas referente a previdencia, que estiverem no array
		         */
		        if(in_array($oDadosRubricasSintetico->rubrica, $aRubricaPrevidencia)){
		          $aDadosRelatorio["nPrevidenciaSintetico"] += $oDadosRubricasSintetico->valor_rubrica;
		        }
		        /**
		         * Valida se a rubrica selecionada faz parte do cálculo de IRRF
		         */
		        if(in_array($oDadosRubricasSintetico->rubrica, $aRubricasIrrf)){
		          $aDadosRelatorio["nIrrfSintetico"]        += $oDadosRubricasSintetico->valor_rubrica;
		        }
		      }
		    }
		  }
		  
		  //$aDadosRelatorio["nLiquidoSintetico"]       = $aDadosRelatorio["nProventoSintetico"] - $aDadosRelatorio["nDescontoSintetico"];
		  //$aDadosRelatorio["nLiquidoSintetico"]       = number_format($aDadosRelatorio["nLiquidoSintetico"], 2, ",", ""); //. " ASASA";
		  
		  //$aDadosRelatorio["nProventoSintetico"]   = number_format($aDadosRelatorio["nProventoSintetico"], 2, ",", "");
		  //$aDadosRelatorio["nDescontoSintetico"]   = number_format($aDadosRelatorio["nDescontoSintetico"], 2, ",", ""); 
		  
		  /**
		   * se o provento nao for zero acrescentamos ao arquivo, caso contrario nao é necessario apresenta-lo;
		   */
		  if((float)$aDadosRelatorio["nProventoSintetico"] > 0) {
		    unset($aDadosRelatorio["nProventoSintetico"]);
		    unset($aDadosRelatorio["nDescontoSintetico"]);
		  	fputcsv($fArquivo, $aDadosRelatorio, ";");
		    unset($aDadosRelatorio);
		  }

		}
		
		/**
		 * CRiando legendas para o relatório analitico
		 */
		if ( $oParam->sAnsin == 'a' ) {
		  $aLegenda   = array();
		  $aLegenda[] = array(" "," ");
		  $aLegenda[] = array("Rubrica","Descrição");
		  foreach ($aDadosRubricas as $oRubrica){
		    $aLegenda[] = array($oRubrica->rubrica, $oRubrica->descr_rubrica);
		  }
		}

		if ( $oParam->sAnsin == 'a' ) {
		  
		  foreach ($aLegenda as $aCSVLegenda) {
		    fputcsv($fArquivo, $aCSVLegenda, ";");
		  }
		}
		
		
		fclose($fArquivo);

		$oRetorno->sArquivo = $sArquivo;
		break;

}
/**
 * Encerrando switch escreve a saida json
 */
echo $oJson->encode($oRetorno);

} catch (Exception $oErro){
  $oRetorno->status  = 2;
  $oRetorno->message = $oErro->getMessage();
  echo $oJson->encode($oRetorno);
}

?>
