<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
include ("classes/db_clabens_classe.php");
include("classes/db_conciliapendcorrente_classe.php");
include("classes/db_db_docparag_classe.php");

$clc_bens= new cl_bens;

db_postmemory($HTTP_POST_VARS);

db_sel_instit();

if (!isset($databaixaini)) {
	$databaini = date("Y-m-d",db_getsession("DB_datausu"));
	$databafim = $databaini;
	$databaixaini = date("d/m/Y",db_getsession("DB_datausu"));
	$databaixafim = $databaixaini;
} else {
  $databaini=implode("-", array_reverse(explode("/", $databaixaini)));
  $databafim=implode("-", array_reverse(explode("/", $databaixafim)));
}
/*
 *  SQL  que retorna os bens baixados  pela data 
 */
$sql.= " select t52_bem , 												";
$sql.=" t55_destino,z01_nome,                                            		";
$sql.=" t52_ident , 													";
$sql.=" t52_descr , 													";
$sql.=" (t44_valoratual+t44_valorresidual) as t44_valoratual ,    										    	";
$sql.=" t55_obs , 														";
$sql.=" t53_empen ,														";
$sql.=" e60_codemp, e60_anousu, t55_motivo,											";
$sql.=" (select t51_descr from bensmotbaixa where t51_motivo = t55_motivo) as motivo ";
$sql.=" from bens left join bensmater on  bens.t52_bem=bensmater.t53_codbem ";
$sql.=" inner join bensbaix on bensbaix.t55_codbem=bens.t52_bem ";
$sql.=" left join bensdepreciacao on t44_bens = t52_bem ";
$sql.=" left join cgm on t55_destino = z01_numcgm ";
$sql.=" left join empempenho on  bensmater.t53_empen=empempenho.e60_numemp "; 
$sql.=" where t55_baixa>='$databaini' and t55_baixa<='$databafim' order by z01_nome,t52_ident";
/*select t52_bem , t52_numcgm , t52_ident , t52_descr , t44_valoratual , t55_obs , t53_empen ,t55_baixa
from bensmater 
right join bens on bens.t52_bem=bensmater.t53_codbem
left join bensbaix on bensbaix.t55_codbem=bens.t52_bem where t55_baixa=*/

$rsBens= $clc_bens->sql_record($sql);//echo $sql;db_criatabela($rsBens);exit;

$intNumRows = $clc_bens->numrows;
if($intNumRows==0)
{
 db_redireciona('db_erros.php?fechar=true&db_erro=N?o existe bens BAIXADOS para esta DATA '.$databaixa);
}

$oResult = db_utils::fieldsMemory($rsBens,0);


$head2 = "RELATÓRIO BAIXA DE BENS";


//$head5 = "Exerc?cio: ". date("Y",db_getsession("DB_datausu"));
if ($databaixaini==$databaixafim) {
  $head5 = "Data : "  .$databaixaini;
} else {
	$head5 = "Período : $databaixaini à $databaixafim ";
}


$alt   = 4;
$fonte = 'arial';

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont($fonte,'',8);
$pdf->addpage();


$dadosadic=ltrim($oResult->t55_obs);


$pdf->setfont($fonte,'b',12);
$pdf->ln(4);
$pdf->cell(189,6,"RELATÓRIO GERAL DE BENS BAIXADOS  ",1,1,"C",0);
$pdf->ln(1);
$valortotal=0;
$qntbens=0;
$valortotalgeral=0;
$qntbensgeral=0;
$sDestino == '';

for($i = 0; $i < $intNumRows ;$i++){
	$oResult = db_utils::fieldsMemory($rsBens,$i);
	
	if (strlen($oResult->t52_descr) > 82 ) {
		$altcol = 8;
	} else {
		$altcol = 4;
	}
	
  if ($pdf->getY() >$pdf->h - 35 || $qntbens == 0) {

    if ($qntbens > 0 || $sDestino == '') {
    	$pdf->setfont($fonte,'b',8);
      $pdf->cell(189,$alt,"Destino: {$oResult->z01_nome}",1,1,"L",0);
      $pdf->cell(189,$alt,"Motivo: {$oResult->motivo}",1,1,"L",0);
      //$pdf->Rect(10,48,189,15);
      $pdf->MultiCell(189,$alt,"Dados Adicionais da Baixa: {$oResult->t55_obs}",1,1,"L",0);
      //$pdf->ln(6);
    }
    $pdf->setfont($fonte,'b',9);
    $pdf->cell(20,$alt,"Placa"           ,1,0,"C",0);
    $pdf->cell(20,$alt,"Empenho"           ,1,0,"C",0);
    $pdf->cell(126,$alt,"Descrição do Bem "      ,1,0,"C",0);
    $pdf->cell(23,$alt,"Valor Unit"          ,1,1,"C",0);

  } else if ($oResult->z01_nome != $sDestino) {
  	$pdf->setfont($fonte,'b',9);
    $pdf->Ln(1);
    $pdf->cell(100,5,"Quantidade de Bens Baixados:    ". $qntbens			,'B',0,"L",0);
    $pdf->cell(89,5," Valor total dos bens baixados: ".db_formatar($valortotal,'f')			,'B',1,"R",0);
    $pdf->Line();
    $pdf->Ln(3);
    $valortotal=0;
	  $qntbens=0;
    
  	$pdf->setfont($fonte,'b',8);
    $pdf->cell(189,$alt,"Destino: {$oResult->z01_nome}",1,1,"L",0);
    $pdf->cell(189,$alt,"Motivo: {$oResult->motivo}",1,1,"L",0);
    //$pdf->Rect(10,48,189,15);
    $pdf->MultiCell(189,$alt,"Dados Adicionais da Baixa: {$oResult->t55_obs}",1,1,"L",0);
    //$pdf->ln(6);
  	
  	$pdf->setfont($fonte,'b',9);
    $pdf->cell(20,$alt,"Placa"           ,1,0,"C",0);
    $pdf->cell(20,$alt,"Empenho"           ,1,0,"C",0);
    $pdf->cell(126,$alt,"Descrição do Bem "      ,1,0,"C",0);
    $pdf->cell(23,$alt,"Valor Unit"          ,1,1,"C",0);
    
  }
 

	$pdf->setfont($fonte,'',7);
	$pdf->cell(20,$altcol,$oResult->t52_ident              											,1,0,"C",0);
	$pdf->cell(20,$altcol,($oResult->e60_codemp != '' ? $oResult->e60_codemp."/".$oResult->e60_anousu : ''),1,0,"C",0);
	//$pdf->cell(126,$alt,$oResult->t52_descr              											,1,0,"L",0);
	
	$pos_x = $pdf->x;
	$pos_y = $pdf->y;
  $pdf->multicell(126,$alt,$oResult->t52_descr,1,"L",0,0);
  $pdf->x = $pos_x+126;
  $pdf->y = $pos_y;
	
	$pdf->cell(23,$altcol,db_formatar($oResult->t44_valoratual,'f')           				,1,1,"C",0);
	

	$valortotal+=$oResult->t44_valoratual ;
	$qntbens++;
	$valortotalgeral+=$oResult->t44_valoratual ;
	$qntbensgeral++;
	$sDestino = $oResult->z01_nome;
}

$pdf->setfont($fonte,'b',9);
$pdf->Ln(2);
$pdf->cell(100,5,"Quantidade de Bens Baixados:    ". $qntbens			,'B',0,"L",0);
$pdf->cell(89,5," Valor total dos bens baixados: ".db_formatar($valortotal,'f')			,'B',1,"R",0);

$pdf->Ln(4);
$pdf->cell(100,5,"Quantidade Geral de Bens Baixados:    ". $qntbensgeral			,'B',0,"L",0);
$pdf->cell(89,5," Valor Total Geral dos bens baixados: ".db_formatar($valortotalgeral,'f')			,'B',1,"R",0);


$pdf->setfont($fonte,'b',6);

$iPosY = $pdf->gety();

$pdf->SetXY(30,$iPosY);
$pdf->multicell(60,2,$sAssCont,0,"C",0,0);

$iPosX = $pdf->getx();

$pdf->SetXY($iPosX+110,$iPosY);
$pdf->multicell(60,2,$sAssSecr,0,"C",0,0);

$sWhere  = " db02_descr like 'ASSINATURA DO RESPONS%VEL' ";
$sWhere .= " AND db03_descr like 'ASSINATURA PADR%O DO RESPONS%VEL' ";
$sWhere .= " AND db03_instit = db02_instit ";
$sWhere .= " AND db02_instit = ".db_getsession('DB_instit');

$cl_docparag = new cl_db_docparag;
$sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);

$rs = $cl_docparag->sql_record($sAssinatura);
$oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;

if($oLinha){
  
  if($pdf->gety() > 270){
    $pdf->AddPage();
    $pdf->Ln(10);
  }else{
    $pdf->Ln(20);
  }

  $pdf->SetLeftMargin(58);
  $pdf->setfont($fonte, 'b', 8);
  $pdf->multiCell(100, 6, $oLinha, 'T', "C", 0, 0);
  
}

$pdf->output();

?>