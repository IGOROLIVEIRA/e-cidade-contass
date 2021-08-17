<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
require_once ("libs/db_utils.php");
require_once("classes/db_arquivoretornodados_classe.php");

$oGet = db_utils::postMemory($_GET);

$clarquivoretornodados = new cl_arquivoretornodados();

$dbwhere = "rh216_instit = ".db_getsession("DB_instit");
$campos = "rh217_nome,(substring(rh217_dn,5,4)||'-'||substring(rh217_dn,3,2)||'-'||substring(rh217_dn,1,2))::date as rh217_dn,rh217_cpf,rh217_nis,array_to_string(rh217_msg,'|') as rh217_msg";

if ($todos == 'false') {
	$dbwhere .= " and rh217_msg is not null";
}
$dbwhere .= " and rh216_dataimportacao = '{$data}'";

$sql = $clarquivoretornodados->sql_query(null,$campos,"rh217_sequencial","{$dbwhere}");

$result = db_query($sql);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem importações na data de '.date_format(date_create($data), 'd/m/Y'));
}

$head3 = "ARQUIVO RETORNO ";
$head4 = "DATA IMPORTAÇÃO : ".date_format(date_create($data), 'd/m/Y');

$pdf = new PDF('L'); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$pdf->addpage();
$pdf->setfillcolor(235);
$alt = 4;
addCabecalho($pdf, $alt);

for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

	if ($pdf->getY() > $pdf->h - 40) {
      $pdf->addpage();
      addCabecalho($pdf, $alt);
  	}

	$oResult = db_utils::fieldsMemory($result, $iCont);
	$aNome = quebrar_texto($oResult->rh217_nome, 27);
	$aMsg = getMessage($oResult->rh217_msg);
	$altlinha = ($alt * (count($aMsg) > 1 ? count($aMsg) : count($aNome)));
	multiCell($pdf, $aNome, $alt, $altlinha, 50);
	$pdf->cell(25,$altlinha,date_format(date_create($oResult->rh217_dn), 'd/m/Y'),1,0,"C",0);
	$pdf->cell(25,$altlinha,db_formatar($oResult->rh217_cpf, 'cpf'),1,0,"C",0);
	$pdf->cell(25,$altlinha,$oResult->rh217_nis,1,0,"C",0);
	multiCellMsg($pdf, $aMsg, $alt, $altlinha, 160);
}

$pdf->Output();

function addCabecalho($pdf, $alt) {

	$pdf->setfont('arial','b',8);

   $pdf->cell(50,$alt,'NOME',1,0,"C",1);
   $pdf->cell(25,$alt,'DT. NASCIMENTO',1,0,"C",1);
   $pdf->cell(25,$alt,'CPF',1,0,"C",1);
   $pdf->cell(25,$alt,'NIS',1,0,"C",1);
   $pdf->cell(160,$alt,'MENSAGENS',1,1,"C",1);

   $pdf->setfont('arial','',8);
}

function multiCellMsg($oPdf,$aTexto,$iTamFixo,$iTam,$iTamCampo) {
	$pos_x = $oPdf->x;
	$pos_y = $oPdf->y;
	foreach ($aTexto as $sProcedimento) {
		$sProcedimento=ltrim($sProcedimento);
		$oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L', 0);
		$oPdf->x=$pos_x;
	}
	$oPdf->x = $pos_x;
	$oPdf->y = $pos_y;
	$oPdf->cell($iTamCampo, $iTam, "", 1, 1, 'L', 0);
}

function getMessage($sMsg) {
	$iTamString = 124;
	$aMsg = explode('|', $sMsg);
	$aMsgNovo = array();
	foreach ($aMsg as $message) {
		$message = !empty($message) ? "- $message" : "";
		if (strlen($message) > $iTamString) {
			$aMsgNovo = array_merge($aMsgNovo, quebrar_texto($message, $iTamString));
			continue;
		}
		$aMsgNovo[] = $message;
	}
	return $aMsgNovo;
}

function quebrar_texto($texto,$tamanho) {

	$aTexto = explode(" ", $texto);
	$string_atual = "";
	foreach ($aTexto as $word) {
		$string_ant = $string_atual;
		$string_atual .= " ".$word;
		if (strlen($string_atual) > $tamanho) {
			$aTextoNovo[] = $string_ant;
			$string_ant   = "";
			$string_atual = $word;
		}
	}
	$aTextoNovo[] = $string_atual;
	return $aTextoNovo;
}

function multiCell($oPdf,$aTexto,$iTamFixo,$iTam,$iTamCampo) {

   if (count($aTexto) == 1) {
   	$oPdf->cell($iTamCampo, $iTam, $aTexto[0], 1, 0, "L", 0);
   	return;
   }
	$pos_x = $oPdf->x;
	$pos_y = $oPdf->y;
	$oPdf->cell($iTamCampo, $iTam, "", 1, 0, 'L', 0);
	$oPdf->x = $pos_x;
	$oPdf->y = $pos_y;
	foreach ($aTexto as $sProcedimento) {
		$sProcedimento=ltrim($sProcedimento);
		$oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L', 0);
		$oPdf->x=$pos_x;
	}
	$oPdf->x = $pos_x+$iTamCampo;
	$oPdf->y = $pos_y;
}

?>