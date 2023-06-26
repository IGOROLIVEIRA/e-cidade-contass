<?
include("fpdf151/pdf.php");
include("classes/db_cgm_classe.php");
require_once("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

/*
 * Definindo o período em que serão selecionado os dados
 */
$iUltimoDiaMes = date("d", mktime(0,0,0,$MesReferencia+1,0,db_getsession("DB_anousu")));
$sDataInicial  = db_getsession("DB_anousu")."-{$MesReferencia}-01";
$sDataFinal    = db_getsession("DB_anousu")."-{$MesReferencia}-{$iUltimoDiaMes}";

switch ($MesReferencia) {
	case "01":
		$sMes = "Janeiro";
		break;
	case "02":
		$sMes = "Fevereiro";
		break;
	case "03":
		$sMes = "Março";
		break;
	case "04":
		$sMes = "Abril";
		break;
	case "05":
		$sMes = "Maio";
		break;
	case "06":
		$sMes = "Junho";
		break;
	case "07":
		$sMes = "Julho";
		break;
	case "08":
		$sMes = "Agosto";
		break;
	case "09":
		$sMes = "Setembro";
		break;
	case "10":
		$sMes = "Outubro";
		break;
	case "11":
		$sMes = "Novembro";
		break;
	case "12":
		$sMes = "Dezembro";
		break;
} 

$head3 = "Exame Aritmético";

$head5= "Mês de Referência: $sMes";

$head6= "Pasta Tipo: Slips";
$head7= "Ordenado por:";


$where = "";
if ($ordenar == 1) {
	
	$head7   .= " Conta";
	$sOrderBy = "credito";
	$where    = "and saiu in ($conta)";
	
} else {
	
	$head7   .= " Recurso";
	$sOrderBy = "c61_codigo";
	$where    = "and ff.o15_codigo in ($recursos)";
	
} 

if ($ordenar == 1 && $conta == "") {
	$where = "";
} else {
	
	if ($ordenar == 2 && $recursos == "") {
		$where = "";
	}
	
}

if (isset($iTipo) && $iTipo != '') {
    
    if ($iTipo == 1) {
        
        $sWhere .= " and o15_codigo in (102,202,15000002,25000002,148,149,150,151,152) ";
        $sTipoPasta = "Saúde 15% ";

    } elseif ($iTipo == 2) {

        $sWhere .= " and o15_codigo in (101, 201, 15000001,25000001) ";
        $sTipoPasta = "Educação 25% ";

    } elseif ($iTipo == 3) {
        
        $sWhere .= " and o15_codigo in (118,119, 218, 219,166,167,266,267,15400007,25400007,15400000,25400000,15420007,25420007,15420000,25420000) ";
        $sTipoPasta = "Fundeb (70% e 30%) ";

    } elseif ($iTipo == 4) {
        $sWhere .= " and ( o15_codigo not in (101, 102, 118, 119, 202, 201, 218, 219,166,167,266,267,157, 17520000,257, 27520000,116, 17500000,216,27500000,15000002,25000002,15000001,25000001,15400007,25400007,15400000,25400000,15420007,25420007,15420000,25420000, 159, 153, 132, 155, 121, 123, 176, 177, 179, 180, 178, 112, 259, 253, 232, 255, 221, 223, 276, 277, 279, 280, 278, 212,148,149,150,151,152,129, 156, 142, 229, 256, 242,107, 147, 143, 144, 145, 146, 122, 171, 172, 175, 174, 173, 120, 106, 113, 207, 247, 243, 244, 245, 246, 222, 271, 272 ,275 ,274 ,273 ,220 ,206 ,213)) ";
        $sWhere .= " and ( SUBSTRING(o15_codtri,1, 4) not in ('1600', '1601', '1602', '1603', '1604', '1621', '1622', '1631', '1632', '1633', '1634', '1635', '1636', '1659', '2600', '2601', '2602', '2603', '2604', '2621', '2622', '2631', '2632', '2633', '2634', '2635', '2636', '2659','1660', '1661', '1662', '1665', '1669', '2660', '2661', '2662', '2665', '2669','1541', '1543', '1544', '1550', '1551', '1552', '1553', '1569', '1570', '1571', '1572', '1573', '1574', '1575', '1576', '1599', '2541', '2543', '2544', '2550', '2551', '2552', '2553', '2569', '2570', '2571', '2572', '2573', '2574', '2575', '2576', '2599')) ";
        $sTipoPasta = "Geral ";
    } elseif ($iTipo == 5) {
        
        $sWhere .= " and o15_codigo in (118, 218,166,266,15400007,25400007,15420007,25420007) ";
        $sTipoPasta = "Fundeb 70% ";

    } elseif ($iTipo == 6) {
        
        $sWhere .= " and o15_codigo in (119, 219,167,267, 15400000,25400000,15420000,25420000) ";
        $sTipoPasta = "Fundeb 30% ";

    } elseif ($iTipo == 7) {
        
        $sWhere .= " and o15_codigo in (157, 17520000,257, 27520000) ";
        $sTipoPasta = "Multas de Transito ";

    } elseif ($iTipo == 8) {
        
        $sWhere .= " and o15_codigo in (116, 17500000,216,27500000) ";
        $sTipoPasta = "CIDE ";

    } elseif ($iTipo == 9) {
        
        $sWhere .= " and (( SUBSTRING(o15_codtri,1, 4) in ('1600', '1601', '1602', '1603', '1604', '1621', '1622', '1631', '1632', '1633', '1634', '1635', '1636', '1659', '2600', '2601', '2602', '2603', '2604', '2621', '2622', '2631', '2632', '2633', '2634', '2635', '2636', '2659'))  or o15_codigo in ('159', '153', '132', '155', '121', '123', '176', '177', '179', '180', '178', '112', '259', '253', '232', '255', '221', '223', '276', '277', '279', '280', '278', '212 ')) ";
        $sTipoPasta = "Vinculados à Saúde ";

    }elseif ($iTipo == 10) {
        
        $sWhere .= " and (( SUBSTRING(o15_codtri,1, 4) in ('1660', '1661', '1662', '1665', '1669', '2660', '2661', '2662', '2665', '2669'))  or o15_codigo in ('129', '156', '142', '229', '256', '242')) ";
        $sTipoPasta = "Vinculados à Assistencia ";

    }elseif ($iTipo == 11) {
        
        $sWhere .= " and (( SUBSTRING(o15_codtri,1, 4) in ('1541', '1543', '1544', '1550', '1551', '1552', '1553', '1569', '1570', '1571', '1572', '1573', '1574', '1575', '1576', '1599', '2541', '2543', '2544', '2550', '2551', '2552', '2553', '2569', '2570', '2571', '2572', '2573', '2574', '2575', '2576', '2599'))  or o15_codigo in ('107', '147', '143', '144', '145', '146', '122', '171', '172', '175', '174', '173', '120', '106', '113', '207', '247', '243', '244', '245', '246', '222', '271', '272 ','275 ','274 ','273 ','220 ','206 ','213 ')) ";
        $sTipoPasta = "Vinculados à Educação ";

    }
}	

$sSqlSlips = "select h.c60_descr,ff.o15_descr,j.c61_codigo,k12_id, k12_autent, k12_data, k12_valor,
		case when (h.c60_codsis = 6 and f.c60_codsis = 6) 
			then 'tran' when (h.c60_codsis = 6 and f.c60_codsis = 5) 
			then 'tran' when (h.c60_codsis = 5 and f.c60_codsis = 6) 
			then 'tran' else 'desp' end as tipo, 
		k12_empen, k12_codord, k12_cheque, entrou as debito, 
		f.c60_descr as descr_debito, f.c60_codsis as sis_debito, 
		saiu as credito, h.c60_descr as descr_credito, 
		h.c60_codsis as sis_credito, sl as k17_codigo,
		corhi as k12_histcor, sl_txt as k17_texto, dta as k17_data
		from 
		(select k12_id, k12_autent, k12_data, k12_valor, tipo, k12_empen, k12_codord,
			k12_cheque, corlanc as entrou, corrente as saiu, slp as sl, 
			corh as corhi, slp_txt as sl_txt, data as dta
				from (select *, case when coalesce(corl_saltes,0) = 0 
					then 'desp' else 'tran' end as tipo 
					from (select corrente.k12_id, corrente.k12_autent, corrente.k12_data, 
						corrente.k12_valor, corrente.k12_conta as corrente, 
						c.k13_conta as corr_saltes, b.k12_conta as corlanc, 
						d.k13_conta as corl_saltes, p.k12_empen, p.k12_codord, 
						p.k12_cheque, slip.k17_codigo as slp, 
						corhist.k12_histcor as corh, slip.k17_texto as slp_txt, slip.k17_data as data
							from corrente 
								inner join corlanc b on corrente.k12_id = b.k12_id 
									and corrente.k12_autent = b.k12_autent 
									and corrente.k12_data = b.k12_data 
								inner join slip on slip.k17_codigo = b.k12_codigo and k17_situacao = 2
								left join corhist on corhist.k12_id = b.k12_id 
									and corhist.k12_data = b.k12_data 
									and corhist.k12_autent = b.k12_autent 
								left join coremp p on corrente.k12_id = 
								p.k12_id 
									and corrente.k12_autent=p.k12_autent 
									and corrente.k12_data = p.k12_data 
								left join saltes c on c.k13_conta = corrente.k12_conta 
								left join saltes d on d.k13_conta = b.k12_conta 
							where corrente.k12_data between '".$sDataInicial."' and '".$sDataFinal."' 
								and corrente.k12_instit = ".db_getsession("DB_instit")." and k12_estorn ='f'  ) 
								as x ) 
							as xx ) 
						as xxx inner join conplanoexe e on entrou = e.c62_reduz 
							and e.c62_anousu = ".db_getsession("DB_anousu")." 
					inner join conplanoreduz i on e.c62_reduz = i.c61_reduz 
						and i.c61_anousu=".db_getsession("DB_anousu")." and i.c61_instit = ".db_getsession("DB_instit")." 
					inner join conplano f on i.c61_codcon = f.c60_codcon 
						and i.c61_anousu = f.c60_anousu 
					inner join conplanoexe g on saiu = g.c62_reduz 
						and g.c62_anousu = ".db_getsession("DB_anousu")." 
					inner join conplanoreduz j on g.c62_reduz = j.c61_reduz 
						and j.c61_anousu=".db_getsession("DB_anousu")." 
					inner join conplano h on j.c61_codcon = h.c60_codcon 
						and j.c61_anousu = h.c60_anousu 
					inner join orctiporec ff on j.c61_codigo = ff.o15_codigo
					where tipo = 'desp' ".$where." ".$sWhere."
					order by tipo, ".$sOrderBy.", k12_data, k12_autent";
					
$rsResultSlips = db_query($sSqlSlips);

$head8 = "Tipo Recursos: $sTipoPasta";

$pdf = new PDF(); // abre a classe
$pdf->Open(); // abre o relatorio
//$pdf->AliasNbPages(); // gera alias para as paginas
$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("","B","");
$pdf->Cell(250,$tam,"SLIPS DO MÊS",1,1,"C",1);		
$nTotalizador = 0;  
for ($$iCont = 0; $iCont < pg_num_rows($rsResultSlips); $iCont++) {
		
  $oResultSlips = db_utils::fieldsMemory($rsResultSlips, $iCont);

  if ($oResultSlips->$sOrderBy != $sContaRec || $iCont == 0) {
  	
  	$pdf->SetFont("","B","");
    if ($ordenar == 1) {
	    $pdf->Cell(250,$tam,"Conta: ".$oResultSlips->credito." - ".$oResultSlips->c60_descr,1,1,"L",1);
    }	else {
    	$pdf->Cell(250,$tam,"Recurso: ".$oResultSlips->c61_codigo." - ".$oResultSlips->o15_descr,1,1,"L",1);
    }
		$pdf->Cell(15,$tam,"Código SLIP",1,0,"C",1);
		$pdf->Cell(105,$tam,"Descrição",1,0,"C",1);
		$pdf->Cell(30,$tam,"Data Slip",1,0,"C",1);
		$pdf->Cell(30,$tam,"Data Pagamento",1,0,"C",1);
		$pdf->Cell(70,$tam,"Valor",1,1,"C",1);
		$sContaRec = $oResultSlips->$sOrderBy;
		$pdf->SetFont("","","");
  	
  }
  
  $pdf->Cell(15,$tam,$oResultSlips->k17_codigo,0,0,"C",0);
  $pdf->Cell(105,$tam,$oResultSlips->descr_debito,0,0,"L",0);
  $pdf->Cell(30,$tam,implode("/", array_reverse(explode("-", $oResultSlips->k17_data))),0,0,"C",0);
  $pdf->Cell(30,$tam,implode("/", array_reverse(explode("-", $oResultSlips->k12_data))),0,0,"C",0);
  $pdf->Cell(70,$tam,number_format($oResultSlips->k12_valor,"2",",",""),0,1,"R",0);

  $nTotalizador += $oResultSlips->k12_valor;
			
}
$pdf->SetFont("","B","");
$pdf->Cell(60,$tam,"Valor Total:",1,0,"C",1);
$pdf->Cell(190,$tam,number_format($nTotalizador,"2",",","."),1,1,"R",1);	
$pdf->output();
	
	?>