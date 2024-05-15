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
require_once("fpdf151/pdf.php");

/**
 * convertendo o array GET em um objeto
 */
$oParam = new stdClass();
foreach ($_GET as $key => $value)
{
    $oParam->$key = $value;
}

$oParam->sFolha = 'r53';
$oParam->sAnsin = 'a';
$oParam->sReg = '0';

$oRetorno            = new stdClass();
$oRetorno->status    = 1;
$oRetorno->message   = 1;
$lErro               = false;
$sMensagem           = "";

$oDadosPessoal           = new  RelatorioEnquadramento();
$aRubricas           = array();
$iTipoFolha          = "";
$iAgrupador          = "";
$aSelecionados       = "";


		
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
		   
		  $oDadosPessoal->setFiltroAgrupador(explode(",", $oParam->sFaixareg));
		}elseif($oParam->sFaixalot != ""){
		   
		  $oDadosPessoal->setFiltroAgrupador(explode(",", $oParam->sFaixalot));
		}elseif($oParam->sFaixaloc != ""){
		   
		  $oDadosPessoal->setFiltroAgrupador(explode(",", $oParam->sFaixaloc));
		}elseif($oParam->sFaixaorg != ""){
		   
		  $oDadosPessoal->setFiltroAgrupador(explode(",", $oParam->sFaixaorg));
		}elseif(!empty($oParam->iRegini) && !(empty($oParam->iRegfim))) {
		   
		  $oDadosPessoal->setFiltroAgrupador($oParam->iRegini, $oParam->iRegfim);
		}elseif (!empty($oParam->iLotini) && !(empty($oParam->iLotfim))){
		   
		  $oDadosPessoal->setFiltroAgrupador($oParam->iLotini, $oParam->iLotfim);
		}elseif (!empty($oParam->iLocini) && !(empty($oParam->iLocfim))){
		   
		  $oDadosPessoal->setFiltroAgrupador($oParam->iLocini, $oParam->iLocfim);
		}elseif (!empty($oParam->iOrgini) && !(empty($oParam->iOrgfim))){
		   
		  $oDadosPessoal->setFiltroAgrupador($oParam->iOrgini, $oParam->iOrgfim);
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
		  $oDadosPessoal->setAfastados(false);
		}
		
		$oDadosPessoal->addTipoFolha   ($iTipoFolha  );
		$oDadosPessoal->setAgrupador   ($iAgrupador  );
		$oDadosPessoal->setCompetencia ($oParam->iMes, $oParam->iAno);
		$oDadosPessoal->setSelecao     ($oParam->sSel);
		//$oDadosPessoal->setRegime      ($oParam->sReg);
		$oDadosPessoal->setCamposQuery ($sCampos     );


		$aDadosPessoal          = $oDadosPessoal->getDadosBase();
		
		$aDadosServidor  = $aDadosPessoal->aDadosServidor;
		
		/*if (count($aDadosServidor) == 0) {
			throw new Exception("Nenhum registro Encontrado");
		}*/
		
$head3 = "Informações Básicas";

$head8 = "Data: ".date("d/m/Y");

$pdf = new PDF(); // abre a classe

$pdf->Open(); // abre o relatorio

$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("","B","");
		
$pdf->Cell(20,$tam,"Matrícula",1,0,"C",1);
$pdf->Cell(70,$tam,"Nome",1,0,"C",1);
$pdf->Cell(90,$tam,"Cargo",1,0,"C",1);
$pdf->Cell(22,$tam,"Admissão",1,0,"C",1);
$pdf->Cell(45,$tam,"Regime",1,0,"C",1);  
$pdf->Cell(22,$tam,"Salário",1,1,"C",1);
$pdf->SetFont("","","");

$iTotalServidores = 0;
$nTotalSalario    = 0;
foreach ($aDadosServidor as $oDadosServidor) {
  
  $pdf->Cell(20,$tam,$oDadosServidor->matricula_servidor,1,0,"C",0);
  $pdf->Cell(70,$tam,$oDadosServidor->nome_servidor,1,0,"L",0);
  $pdf->Cell(90,$tam,$oDadosServidor->descr_cargo,1,0,"L",0);
  $pdf->Cell(22,$tam,implode("/", array_reverse(explode("-", $oDadosServidor->data_admissao))),1,0,"C",0);
  $pdf->Cell(45,$tam,$oDadosServidor->descr_regime,1,0,"L",0);  
  $pdf->Cell(22,$tam,"R$ ".number_format($oDadosServidor->salario_base, 2, ",", "."),1,1,"R",0);
  
  $iTotalServidores++;
  $nTotalSalario += $oDadosServidor->salario_base;
     
}
$pdf->SetFont("","B","08");
$pdf->Cell(269,$tam,"",0,1,"C",0); 
$pdf->Cell(269,$tam,"",0,1,"C",0); 

$pdf->Cell(269,"12","Total de Servidores: $iTotalServidores",0,1,"L",0);  
$pdf->Cell(269,"12","Total de Salários R$ ".number_format($nTotalSalario, 2, ",", "."),0,1,"L",0);

$pdf->output();

?>
