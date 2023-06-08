<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");

if ($controle == 1) {
  $sSql = "select * from  bens       
  inner join cgm                on  cgm.z01_numcgm = bens.t52_numcgm      
  inner join db_depart          on  db_depart.coddepto = bens.t52_depart      
  inner join clabens            on  clabens.t64_codcla = bens.t52_codcla      
  inner join clabensconplano    on  clabensconplano.t86_clabens = clabens.t64_codcla                                    and clabensconplano.t86_anousu = 2013      
  inner join conplano           on  conplano.c60_codcon  = clabensconplano.t86_conplano                                    and conplano.c60_anousu = 2013      
  left  join bensdiv            on  bensdiv.t33_bem = bens.t52_bem      
  left  join departdiv          on  departdiv.t30_codigo = bensdiv.t33_divisao      
  left  join departdiv as b     on  b.t30_depto  = db_depart.coddepto      
  left  join histbem            on  histbem.t56_codbem   = bens.t52_bem and histbem.t56_depart = bens.t52_depart      
  left  join situabens          on  situabens.t70_situac = histbem.t56_situac      
  inner join bensmarca          on  bensmarca.t65_sequencial = bens.t52_bensmarca      
  inner join bensmodelo         on  bensmodelo.t66_sequencial = bens.t52_bensmodelo      
  inner join bensmedida         on  bensmedida.t67_sequencial = bens.t52_bensmedida
  inner join bensmater          on  bensmater.t53_codbem = bens.t52_bem  
  where  t52_ident = '". $placa_ident ."'  and t52_instit = 1";
} else {
	if (isset($t53_codbem)) {
		$where = " t52_bem = $t53_codbem "; 
	} else if (isset($t42_codigo)) {
		$sql = "select * from benslote join benscadlote on t43_codlote = t42_codigo where t43_codlote = $t42_codigo";
		$result = db_query($sql);
		$t42_descr = db_utils::fieldsMemory($result, 0)->t42_descr;
		for ($y = 0; $y < pg_num_rows($result); $y++) {
			$array_bens[] = db_utils::fieldsMemory($result, $y)->t43_bem;
		}
		$where = " t52_bem in (".implode(",", $array_bens).") ";
	}
  $sSql = "select distinct t52_bem,t52_ident,t53_empen,descrdepto,departdiv.t30_descr,t64_descr,t52_dtaqu,t70_descr,t53_garant,t53_ordem,t53_ntfisc,t52_descr,t52_valaqu from  bens       
  inner join cgm                on  cgm.z01_numcgm = bens.t52_numcgm      
  inner join db_depart          on  db_depart.coddepto = bens.t52_depart      
  inner join clabens            on  clabens.t64_codcla = bens.t52_codcla      
  inner join clabensconplano    on  clabensconplano.t86_clabens = clabens.t64_codcla                                    and clabensconplano.t86_anousu = ".db_getsession("DB_anousu")."      
  inner join conplano           on  conplano.c60_codcon  = clabensconplano.t86_conplano                                    and conplano.c60_anousu = ".db_getsession("DB_anousu")."      
  left  join bensdiv            on  bensdiv.t33_bem = bens.t52_bem      
  left  join departdiv          on  departdiv.t30_codigo = bensdiv.t33_divisao      
  left  join departdiv as b     on  b.t30_depto  = db_depart.coddepto      
  left  join histbem            on  histbem.t56_codbem   = bens.t52_bem and histbem.t56_depart = bens.t52_depart      
  left  join situabens          on  situabens.t70_situac = histbem.t56_situac      
  inner join bensmarca          on  bensmarca.t65_sequencial = bens.t52_bensmarca      
  inner join bensmodelo         on  bensmodelo.t66_sequencial = bens.t52_bensmodelo      
  inner join bensmedida         on  bensmedida.t67_sequencial = bens.t52_bensmedida
  inner join bensmater          on  bensmater.t53_codbem = bens.t52_bem  
  where  $where  and t52_instit = 1 order by t52_bem";
}

$rsBenIncorp = db_query($sSql);//echo pg_last_error();
$oBenIncorp  = db_utils::fieldsMemory($rsBenIncorp, 0);//db_criatabela($rsBenIncorp);exit;

$sSql = "select e60_codemp from empempenho where e60_numemp = '".$oBenIncorp->t53_empen."'";
$rsNumemp = db_query($sSql);
$iCodemp  = db_utils::fieldsMemory($rsNumemp, 0)->e60_codemp;

//print_r($oBenIncorp);exit;	

/**
 * Começamos o arquivo PDF em sí
 */
$oPdf  = new PDF();
$oPdf->Open();
$oPdf->SetFillColor(235);
$head3 = "FICHA DE INCORPORAÇÃO DE BEM";
$head4 = "EXERCÍCIO: ". db_getsession('DB_anousu');
$head5 = "Departamento: ". $oBenIncorp->descrdepto;
$data = implode('/', array_reverse(explode("-", date("Y-m-d"))));
$head6 = "Data: ". $data;

$iAlturaCelula = 4;
$oPdf->AddPage();

$oPdf->setfont('arial','b',8);
$oPdf->cell(0,$iAlturaCelula,'DADOS DO BEM',0,1,"C",0);
$oPdf->cell(0,$iAlturaCelula,'','T',1,"R",0);

$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Departamento :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->descrdepto, 0, 1, "L", 0);
$oPdf->ln();
$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Divisão :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t30_descr, 0, 1, "L", 0);
$oPdf->ln();
$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Classificação :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t64_descr, 0, 1, "L", 0);
$oPdf->ln();
$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Aquisição :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t52_dtaqu, 0, 1, "L", 0);
$oPdf->ln();
$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Placa :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t52_ident, 0, 1, "L", 0);
$oPdf->ln();
$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Lote :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $t42_descr, 0, 1, "L", 0);
$oPdf->ln();
$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Situação :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t70_descr, 0, 1, "L", 0);

$oPdf->setfont('arial','b',8);
$oPdf->cell(0,$iAlturaCelula,'DADOS DO MATERIAL',0,1,"C",0);
$oPdf->cell(0,$iAlturaCelula,'','T',1,"R",0);

$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Número do Empenho :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $iCodemp, 0, 1, "L", 0);

$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Garantia :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t53_garant, 0, 1, "L", 0);

$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Ordem de Compra :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t53_ordem, 0, 1, "L", 0);

$oPdf->SetFont('arial', 'b', 8);
$oPdf->Cell(30, $iAlturaCelula, 'Nota Fiscal :', 0, 0, "R", 0);
$oPdf->SetFont('arial', '', 7);
$oPdf->Cell(30, $iAlturaCelula, $oBenIncorp->t53_ntfisc, 0, 1, "L", 0);

$oPdf->ln();
$primeiro = 1;
for ($x = 0; $x < pg_num_rows($rsBenIncorp); $x++) {

	$oBenIncorp  = db_utils::fieldsMemory($rsBenIncorp, $x);
  if ($oPdf->gety() > $oPdf->h - 30 || $primeiro != 0) {

    if ($oPdf->gety() > $oPdf->h - 30) {
      $oPdf->addpage();
    }
	  $oPdf->SetFont('arial', 'b', 8);
	  $oPdf->Cell(30, $iAlturaCelula, 'Placa(s)', 1, 0, "L", 0);
	  $oPdf->Cell(65, $iAlturaCelula, 'Descrição do bem', 1, 0, "L", 0);
	  $oPdf->Cell(30, $iAlturaCelula, 'Qtdd', 1, 0, "L", 0);
	  $oPdf->Cell(30, $iAlturaCelula, 'Valor Unit', 1, 0, "L", 0);
	  $oPdf->Cell(30, $iAlturaCelula, 'Valor Total', 1, 1, "L", 0);
	  
	  $primeiro = 0;
	
  }
	
	  if (strlen($oBenIncorp->t52_descr) > 65 ) {               
		     $aDescricao = quebrar_texto($oBenIncorp->t52_descr,65);  
		     $alt_novo = count($aDescricao);                   
	  } else {
		     $alt_novo = 1;
	  }
	  
	$oPdf->SetFont('arial', '', 7);
	
	$placa1 = $oBenIncorp->t52_ident;
	$placa2 = $oBenIncorp->t52_ident+$qtd_cont-1;
	
	if ($qtd_cont > 1) {
		$oPdf->Cell(30, $iAlturaCelula*$alt_novo, $placa1 .'->'. $placa2 , 1, 0, "L", 0);
	}else{
		$oPdf->Cell(30, $iAlturaCelula*$alt_novo, $oBenIncorp->t52_ident, 1, 0, "L", 0);
	}
	
	//$oPdf->Cell(30, $iAlturaCelula*$alt_novo, $oBenIncorp->t52_ident .','. $oBenIncorp->t52_ident+  , 1, 0, "L", 0);
	
	$i = 0;
	$ctr = count($aDescricao);
	
	if (strlen($oBenIncorp->t52_descr) > 65) {
		                 $pos_x = $oPdf->x;
		                 $pos_y = $oPdf->y;
		                 foreach ($aDescricao as $descricao_nova) {
		                 		 $i++;
		                 		 $descricao_nova = ltrim($descricao_nova);
		                 		 if ($ctr == $i) {
		  						 	$borda = "B";
		  						 } else {
		  						 	$borda = "";
		  						 }
		                         $oPdf->cell(65,$iAlturaCelula,substr($descricao_nova, 0, 30),$borda,1,"L",0);
		                         $oPdf->x=$pos_x;   
		  						                       
		                 }
		                 $oPdf->x = $pos_x+65;
						 $oPdf->y = $pos_y;
		} else {
		                 $oPdf->cell(65,($iAlturaCelula*$alt_novo),substr($oBenIncorp->t52_descr, 0, 65),1 ,0,"L",0);
		}
	
	//$oPdf->Cell(65, $iAlturaCelula, $oBenIncorp->t52_descr , 1, 0, "L", 0);
	
	if ($qtd_cont > 1) {
		$oPdf->Cell(30, $iAlturaCelula*$alt_novo, $qtd_cont , 1, 0, "L", 0);
	}else{
		$oPdf->Cell(30, $iAlturaCelula*$alt_novo, '1' , 1, 0, "L", 0);
	}
	
	$oPdf->Cell(30, $iAlturaCelula*$alt_novo, $oBenIncorp->t52_valaqu , 1, 0, "L", 0);
	if ($qtd_cont > 1) {
	    $oPdf->Cell(30, $iAlturaCelula*$alt_novo, $qtd_cont*$oBenIncorp->t52_valaqu , 1, 1, "L", 0);
	}else{
		$oPdf->Cell(30, $iAlturaCelula*$alt_novo, $oBenIncorp->t52_valaqu , 1, 1, "L", 0);
	}

}

$oPdf->Output();

function quebrar_texto($texto,$tamanho){

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
