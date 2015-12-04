<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$mesusu = db_mes($mesusu, 1);

$dbwhere = "";

if ($lista != "") {
  if (isset ($condicao) and $condicao == "com") {
    $dbwhere .= " and x01_rota in  ($lista)";
  } else {
    $dbwhere .= " and x01_rota not in  ($lista)";
  }
}



/***
 *
 * Rotina que Imprime a Planilha de Leituras
 *
 */

$rotulo = new rotulocampo();
$rotulo->label("x01_entrega");
$rotulo->label("x01_zona");
$rotulo->label("x07_codrota");
$rotulo->label("x04_matric");
$rotulo->label("z01_nome");
$rotulo->label("x04_nrohidro");
$rotulo->label("j88_sigla");
$rotulo->label("j14_nome");
$rotulo->label("x01_numero");
$rotulo->label("x01_letra");
$rotulo->label("x01_codrua");
$rotulo->label("x11_complemento");
$rotulo->label("x21_leitura");
$rotulo->label("x21_situacao");
$rotulo->label("j13_descr");

$sql = "
			select x01_zona,
						 coalesce(x06_codrota, 999999) as x07_codrota,
             coalesce(x06_descr, 'SEM ROTA DEFINIDA') as x06_descr,
						 x04_matric,
						 z01_nome,
						 x04_nrohidro,
             x01_codrua,
						 j88_sigla,
						 j14_nome,
						 x01_numero,
						 x01_letra,
						 x11_complemento,
						 j13_descr,
             0::float8 as x21_leitura,
             0::integer as x21_situacao 
			  from aguahidromatric
             left join  aguahidrotroca     on x28_codhidrometro = x04_codhidrometro
             inner join aguabase           on x01_matric = x04_matric
             left  join aguabasebaixa      on x08_matric = x04_matric
             inner join cgm                on z01_numcgm = x01_numcgm
             left  join aguaconstr         on x11_matric = x04_matric 
                                          and x11_tipo = 'P'
             inner join ruas               on j14_codigo = x01_codrua
             left  join ruastipo           on j88_codigo = j14_tipo	
             inner join bairro             on j13_codi = x01_codbairro
             left  join aguarota           on x06_codrota = x01_rota
       where x28_codigo is null 
         and x08_matric is null 
             $dbwhere
		order by x07_codrota, x01_codrua, x01_letra, x01_numero
 ";

//die($sql);
$result = pg_exec($sql);
$numrows = pg_numrows($result);

if ($numrows == 0){
	db_redireciona('db_erros.php?fechar=true&db_erro=Nao existem itens cadastrados para fazer a consulta.');
}

$head2 = "LEITURA DE HIDROMETROS    Ref.: $mesusu/$anousu";
$head4 = "";
$head8 = "";

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$alt = 7;
$total = 0;
$fator = 1.2;
$largSit = 52;
$inicio = true;

for($x=0; $x<$numrows; $x++) {
	db_fieldsmemory($result,$x);

	if($x01_letra == "S" || $x01_letra == "D" || $x01_letra == "E") {	
	  $letra = $x01_letra;
	}else{
		$letra = "";
	}
	
	//$logradouro = "Logradouro: " . $x01_codrua . " - " . $j88_sigla . " " . $j14_nome . "  ".$letra;
	//$logradouro = "Logradouro: " . $x01_codrua . " - " . $j14_nome ;
	$logradouro = "Logradouro: " . $x01_codrua . " - " . $j14_nome . " " . $letra;
	
	if ($pdf->gety() > $pdf->h - 25 || $head4 != $logradouro ){
		$head4 = $logradouro;
		$head6 = "Zona: " . $x01_zona . "   Rota: " . $x07_codrota . " - " . $x06_descr;

    if(!$inicio) {
		  $pdf->SetFont('courier','b',8);
      $pdf->text(10,285,'DATA: ..../..../....                          ASSINATURA LEITURISTA: ________________________________________ ');
		} else {
			$inicio = false;
		}

		$pdf->addpage();
		$pdf->setfont('arial','b',8);

		$pdf->cell(0,$alt,"",0,1,"C",0);
		
		$pdf->cell($Mx04_matric*$fator      , $alt, $RLx04_matric,1,0,"C",1);
		$pdf->cell(($Mz01_nome+6)*$fator        , $alt, $RLz01_nome,1,0,"C",1);
		$pdf->cell(($Mx01_numero+6)*$fator      , $alt, substr($RLx01_numero,0,3),1,0,"C",1);
		$pdf->cell(($Mx11_complemento+8)*$fator , $alt, $RLx11_complemento,1,0,"C",1);
		$pdf->cell($Mx04_nrohidro*$fator    , $alt, "Hidrometro",1,0,"C",1);
		$pdf->cell($Mx04_matric*$fator      , $alt, $RLx04_matric,1,0,"C",1);
		$pdf->cell(($Mx21_leitura+4)*$fator , $alt, $RLx21_leitura,1,0,"C",1);
		$pdf->cell(($Mx21_situacao+4)*$fator    , $alt, substr($RLx21_situacao,0,3),1,1,"C",1);
	}
	$pdf->setfont('courier','',10);
	//$fundo = ($x%2)==0?0:1;
	$fundo = 0;
  $letra2 = empty($x01_letra)?"":"/".$x01_letra;
	$pdf->cell($Mx04_matric*$fator      , $alt, $x04_matric,1,0,"C",$fundo);
	$pdf->cell(($Mz01_nome+6)*$fator        , $alt, substr($z01_nome,0,26),1,0,"L",$fundo);
	$pdf->cell(($Mx01_numero+6)*$fator      , $alt, $x01_numero.$letra2,1,0,"R",$fundo);

	$pdf->setfont('courier','',9);
	$pdf->cell(($Mx11_complemento+8)*$fator , $alt, $x11_complemento,1,0,"C",$fundo);
	$pdf->setfont('courier','',9);
	
	$pdf->cell($Mx04_nrohidro*$fator    , $alt, $x04_nrohidro,1,0,"C",$fundo);
	$pdf->cell($Mx04_matric*$fator      , $alt, $x04_matric,1,0,"C",$fundo);
	$pdf->cell(($Mx21_leitura+4)*$fator , $alt, "",1,0,"C",$fundo);
	$pdf->cell(($Mx21_situacao+4)*$fator    , $alt, "",1,1,"C",$fundo);

  /*$pdf->cell($Mx01_numero*$fator     ,$alt,$x01_numero,1,0,"C",$fundo);
	$pdf->cell($Mx11_complemento*$fator,$alt,$x11_complemento,1,0,"C",$fundo);
	$pdf->cell($Mx04_nrohidro*$fator   ,$alt,$x04_nrohidro,1,0,"L",$fundo);
	$pdf->cell($Mx03_sigla*$fator      ,$alt,$x03_sigla,1,0,"L",$fundo);
	$pdf->cell($Mx42_codsituacao*$fator,$alt,$x42_codsituacao,1,0,"C",$fundo);
	$pdf->cell($Mx01_matric*$fator     ,$alt,$x01_matric,1,0,"R",$fundo);
	$pdf->cell($largSit*$fator         ,$alt,"",1,1,"C",$fundo);*/
	$total++;
}

//$pdf->setfont('courier','b',8);
//$pdf->cell(192,$alt,'TOTAL DE REGISTROS  :  '.$total,"T",0,"L",0);

$pdf->Output();

	
?>
