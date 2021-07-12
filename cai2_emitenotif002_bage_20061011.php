<?
include("libs/db_sql.php");
include("fpdf151/scpdf.php");
//db_postmemory($HTTP_SERVER_VARS,2);exit;
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
if ( $lista == '' ) {
   db_redireciona('db_erros.php?fechar=true&db_erro=Lista não encontrada!');
   exit; 
}
$sqlinst = "select * from db_config where codigo = ".db_getsession("DB_instit");
db_fieldsmemory(pg_exec($sqlinst),0,true);

$sqlparag = "select db02_texto
	from db_documento 
	inner join db_docparag on db03_docum = db04_docum
	inner join db_tipodoc on db08_codigo  = db03_tipodoc
	inner join db_paragrafo on db04_idparag = db02_idparag 
	where db03_tipodoc = 1017 and db03_instit = " . db_getsession("DB_instit")." order by db04_ordem ";
$resparag = pg_query($sqlparag);

if ( pg_numrows($resparag) == 0 ) {
	 $head1 = 'SECRETARIA DE FINANÇAS';
} else {
	db_fieldsmemory( $resparag, 0 );
	$head1 = $db02_texto;
}

global $pdf;
$pdf = new SCPDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 

$pdf->SetAutoPageBreak(true,0); 

$sqlvenc = "select now() + '30 days'::interval as db_datausu";
$resultvenc = pg_exec($sqlvenc) or die($sqlvenc);
db_fieldsmemory($resultvenc, 0);

//$db_datausu = date("Y-m-d");
$DB_DATACALC = mktime(0,0,0,substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4));


$sql = "select * from lista where k60_codigo = $lista";
$result = pg_exec($sql);
db_fieldsmemory($result,0);

$sqllistatipo = "select listatipos.*, arretipo.k03_tipo, k03_descr from listatipos inner join arretipo on k00_tipo = k62_tipodeb inner join cadtipo on arretipo.k03_tipo = cadtipo.k03_tipo where k62_lista = $lista";
//die($sqllistatipo);
$resultlistatipo = pg_exec($sqllistatipo);
$virgula = '';
$tipos = '';
$descrtipo = '';
$somenteparc = true;
$somenteiptu = true;
for($yy = 0;$yy < pg_numrows($resultlistatipo);$yy++ ) {
   db_fieldsmemory($resultlistatipo,$yy);
   $tipos .= $virgula.$k62_tipodeb;
   $descrtipo .= $virgula.trim($k03_descr);
   $virgula = ' , ';

	 if ($k03_tipo != 6 and $k03_tipo != 13 and $k03_tipo != 16) {
		 $somenteparc = false;
	 }
	 if ($k03_tipo != 1) {
		 $somenteiptu = false;
	 }
}

$sqllistadoc = "select * from listadoc where k64_codigo = $lista";
$resultlistadoc = pg_exec($sqllistadoc);

if ($resultlistadoc == false) {
   db_redireciona('db_erros.php?fechar=true&db_erro=Erro ao procurar documento desta lista!');
   exit; 
}

if (pg_numrows($resultlistadoc) == 0) {
   db_redireciona('db_erros.php?fechar=true&db_erro=Nao encontrou documento desta lista!');
   exit; 
}

//echo "tipo".$tipos ;exit;
if ($k60_tipo == 'M'){
    $xtipo    = 'Matrícula';
    $xcodigo  = 'matric';
//    $xcodigo1 = 'j01_matric';
    $xcodigo1 = 'j01_matric';
    $xxcodigo1 = 'k55_matric';
		$xcampos = ' substr(fc_proprietario_nome,1,7) as z01_numcgm, substr(fc_proprietario_nome,8,40) as z01_nome ';
    $xxmatric = ' inner join notimatric on matric = k55_matric ';
    $xxmatric2 = '';
////		$xxmatric2 = ' inner join proprietario_nome on j01_matric = matric ';
    $xxcodigo = 'k55_notifica';
    if (isset($campo)){
       if ($tipo == 2){
          $contr = 'and matric in ('.str_replace("-",", ",$campo).') ';
       }elseif ($tipo == 3){
          $contr = 'and matric not in ('.str_replace("-",", ",$campo).') ';
       }
    }else{
       $contr = '';
    }
}elseif($k60_tipo == 'I'){
    $xtipo    = 'Inscrição';
    $xcodigo  = 'inscr';
    $xcodigo1 = 'q02_inscr';
    $xxcodigo1 = 'k56_inscr';
    $xxmatric = ' inner join notiinscr on inscr = k56_inscr ';
		$xxmatric2 = ' inner join issbase on q02_inscr = inscr inner join cgm on z01_numcgm = q02_numcgm';
    $xxcodigo = 'k56_notifica';
		$xcampos = ' z01_numcgm, z01_nome ';
    if (isset($campo)){
       if ($tipo == 2){
          $contr = 'and inscr in ('.str_replace("-",", ",$campo).') ';
       }elseif ($tipo == 3){
          $contr = 'and inscr not in ('.str_replace("-",", ",$campo).') ';
       }
    }else{
       $contr = '';
    }

}elseif($k60_tipo == 'N'){
    $xtipo    = 'Numcgm';
    $xcodigo  = 'numcgm';
    $xcodigo1 = 'j01_numcgm';
    $xxcodigo1 = 'k57_numcgm';
    $xxmatric = ' inner join notinumcgm on numcgm = k57_numcgm ';
    $xxmatric2 = ' inner join cgm on numcgm = z01_numcgm ';
    $xxcodigo = 'k57_notifica';
		$xcampos = ' z01_numcgm, z01_nome ';
    if (isset($campo)){
       if ($tipo == 2){
          $contr = 'and numcgm in ('.str_replace("-",", ",$campo).') ';
       }elseif ($tipo == 3){
          $contr = 'and numcgm not in ('.str_replace("-",", ",$campo).') ';
       }
    }else{
       $contr = '';
    }
}

if($ordem == 'a'){
  $xxordem = ' order by z01_nome ';
	$xxxordem = ' order by substr(fc_proprietario_nome,8,40)';
}elseif($ordem == 't'){
  $xxordem = ' order by '.$xxcodigo;
  $xxxordem = ' order by notifica';
}else{
  $xxordem = ' order by '.$xxcodigo1;
  $xxxordem = ' order by '.$xxcodigo1;
}
//echo $ordem."<br>";
//echo $xxordem."<br>";
if($fim > 0 && $intervalo == 'n'){
  $limite = 'and '.$xxcodigo.' >= '.$inicio.' and '.$xxcodigo.' <= '.$fim;
}else{
  $limite = '';
}

$sql999 = "select $xxcodigo as notifica,$xcodigo1,z01_numcgm,z01_nome,sum(valor_vencidos) as xvalor
        from 
             (select distinct $xcodigo as $xcodigo1,
                     $xxcodigo,
                     z01_numcgm,
                     z01_nome,
                     valor_vencidos
              from 
                   (select distinct k61_numpre,k61_codigo,k60_datadeb 
 	            from listadeb 
	 	         inner join lista on k60_codigo = k61_codigo
                    where k61_codigo = $lista ) as a
              inner join devedores b on a.k61_numpre = b.numpre and b.data = a.k60_datadeb
              $xxmatric $limite $contr
              inner join cgm on z01_numcgm = b.numcgm
        where k61_codigo = $lista ) as y
        group by $xxcodigo,
                 $xcodigo1,
                 z01_numcgm,
                 z01_nome
        $xxordem
        ";
//die($sql999);

if ($k60_tipo != 'M'){
	$sql = "select $xxcodigo as notifica,$xxcodigo1 as $xcodigo1, $xcampos, sum(valor_vencidos) as xvalor
					from lista
							 inner join listanotifica on k63_codigo = k60_codigo
							 inner join devedores on data = '$k60_datadeb' and numpre = k63_numpre
							 $xxmatric  and $xxcodigo = k63_notifica $xxmatric2 $limite $contr
					where k60_codigo = $lista 
					group by $xxcodigo,
									 $xxcodigo1,
									 z01_numcgm,
									 z01_nome
					$xxordem
					";
} else {

	$sql = "select 	notifica,
									$xcodigo1,
									xvalor,
									substr(fc_proprietario_nome,1,7) as z01_numcgm,
									substr(fc_proprietario_nome,8,40) as z01_nome
					from (
					select 	$xxcodigo as notifica,
									$xxcodigo1 as $xcodigo1,
									fc_proprietario_nome($xxcodigo1),
									sum(valor_vencidos) as xvalor
					from lista
							 inner join listanotifica on k63_codigo = k60_codigo
							 inner join devedores on data = '$k60_datadeb' and numpre = k63_numpre
							 $xxmatric  and $xxcodigo = k63_notifica $xxmatric2 $limite $contr
					where k60_codigo = $lista 
					group by $xxcodigo,
									 $xxcodigo1
          ) as x 
					$xxxordem;
					";
					
}

//echo $sql;exit;
$result = pg_exec($sql);
//db_criatabela($result);
if (pg_numrows($result) == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Nenhuma notificação gerada para a lista '.$lista);
   exit; 
} 

if($fim > 0 && $intervalo != 'n'){
  if($inicio > 0){
    $lim1 = $inicio - 1;
  }else{
    $lim = 0;
  }
  if($fim > pg_numrows($result)){
    $lim2 = pg_numrows($result);
  }else{
    $lim2 = $fim;
  }
}else{
  $lim1 = 0;
  $lim2 = pg_numrows($result);
}

if ( $tiporel == 1 or $tiporel == 11 ) {
  
   for($x=$lim1;$x < $lim2;$x++) {
      db_fieldsmemory($result,$x);

//      db_criatabela(pg_exec("select $notifica"));

      $sqljapagou = "	select *
			from notidebitos
				inner join debitos on debitos.k22_numpre = notidebitos.k53_numpre and debitos.k22_numpar = notidebitos.k53_numpar and debitos.k22_data = '$k60_datadeb'
				inner join arretipo on arretipo.k00_tipo = debitos.k22_tipo
				inner join arrecad on arrecad.k00_numpre = notidebitos.k53_numpre and arrecad.k00_numpar = notidebitos.k53_numpar
				where notidebitos.k53_notifica = $notifica
				limit 1";
      $resultjapagou = pg_exec($sqljapagou);
      if ($resultjapagou == false) {
	db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao verificar se ja pagou! sql: '.$sqljapagou);
	exit;
      }

      if (pg_numrows($resultjapagou) == 0) {
	continue;
      }

      $pdf->AddPage();
      CabecNotif(&$pdf,0,"");
      $pdf->SetFont('Arial','',13);
      $numcgm = @$j01_numcgm;
      $matric = @$j01_matric;
      $inscr  = @$q02_inscr;
      if($matric != ''){
         $xmatinsc = " matric = ".$matric." and ";
         $xmatinsc22 = " k22_matric = ".$matric." and ";
         $matinsc = "sua matrícula n".chr(176)." ".$matric;
      }else if($inscr != ''){
         $xmatinsc = " inscr = ".$inscr." and ";
         $xmatinsc22 = " k22_inscr = ".$inscr." and ";
         $matinsc = "sua inscrição n".chr(176)." ".$inscr;
      }else{
         $xmatinsc = " numcgm = ".$numcgm." and ";
         $xmatinsc22 = " k22_numcgm = ".$numcgm." and ";
         $matinsc = "V.Sa.";
      }
      $matricula = $matric;
      $inscricao = $inscr;
      $jtipos = '';
      $num2 = 0;

      if ($tipos != ''){
	 $jtipos = ' tipo in ('.$tipos.') and ';
         $sql2 = "select tipo,k00_descr,sum(valor_vencidos) as valor 
				 					from devedores 
				 					inner join arretipo on k00_tipo = tipo 
									where $xmatinsc tipo not in ($tipos) and data = '$k60_datadeb' group by tipo,k00_descr";
         $result2 = pg_exec($sql2);
	 $num2 = pg_numrows($result2);
      }

      if (1 == 2) {

	$sqltipos = "	select 	distinct cadtipo.k03_tipo, cadtipo.k03_descr 
			  from notidebitos
				  inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				  inner join arretipo on k00_tipo = k22_tipo 
				  inner join cadtipo on arretipo.k03_tipo = cadtipo.k03_tipo
				  where k53_notifica = $notifica
				  ";
  //      die($sqltipos);
	$resultatipos = pg_exec($sqltipos);
	$virgula = '';
	$descrtipo = '';
	$codtipos = '';
	for($i = 0;$i < pg_numrows($resultatipos);$i++){
	   db_fieldsmemory($resultatipos,$i);
	   $descrtipo .= $virgula.$k03_descr;
	   $codtipos  .= $virgula.$k03_tipo;
	   $virgula = ', ';
	}

      }




      $cgm = $z01_numcgm;
      $sql1 = "select tipo,k00_descr,sum(valor_vencidos) as valor from devedores inner join arretipo on k00_tipo = tipo where $xmatinsc $jtipos data = '$k60_datadeb' group by tipo,k00_descr";
      $result1 = pg_exec($sql1);

      if ($k60_tipo == 'M'){

        $sqlpropri = "select z01_nome, codpri, nomepri, j39_numero, j39_compl, j34_setor, j34_quadra, j34_lote, j34_zona, j34_area, j01_tipoimp from proprietario where j01_matric = $matric";
        $resultpropri = pg_exec($sqlpropri);
	if (pg_numrows($resultpropri) > 0) {
	  db_fieldsmemory($resultpropri,0);
	}

        $sqlender = "select fc_iptuender($matric)";
        $resultender = pg_exec($sqlender);
        db_fieldsmemory($resultender,0);

//	echo("matric: $matric<br>\n");exit;
        $endereco = explode("#",$fc_iptuender);

        $z01_ender    = $endereco[0];
        $z01_numero   = $endereco[1];
        $z01_compl    = $endereco[2];
        $z01_bairro   = $endereco[3];
        $z01_munic    = $endereco[4];
        $z01_uf       = $endereco[5];
        $z01_cep      = $endereco[6];
        $z01_cxpostal = $endereco[7];
	
      } elseif ($k60_tipo == 'I') {

	$imprime = "INSCRICAO: $q02_inscr";

	$sqlempresa = "select * from empresa where q02_inscr = $q02_inscr";
	$resultempresa = pg_exec($sqlempresa);
	if (pg_numrows($resultempresa) > 0) {
	  db_fieldsmemory($resultempresa,0);
	}

      } else {
	$sqlender = "select z01_ender, z01_numero, z01_compl, z01_bairro, z01_munic, z01_uf, z01_cep, z01_cxpostal from cgm where z01_numcgm = $cgm";
	$resultender = pg_exec($sqlender);
        db_fieldsmemory($resultender,0,true);
      }

      $impostos = '';
      $virgula  = '';
      $xvalor   = 0;
//      $notifica = 50; 

 
      $impostos  = 'DÍVIDA ATIVA' ;
      $impostos2 = '';
      $virgula2  = '';
      $xvalor2   = 0;

      $sqldocparagr = "select * from db_docparag 
      				inner join listadoc 		on db04_docum = k64_docum 
				inner join db_paragrafo 	on db02_idparag = db04_idparag 
				where k64_codigo = $lista
				order by db04_ordem";
      $resultdocparagr = pg_exec($sqldocparagr) or die($sqldocparagr);
      global $db02_inicia;
      global $db02_espaca;
//-----------------DATA--------------------
      $sqltexto = "select munic from db_config where codigo = " . db_getsession("DB_instit");
      $resulttexto = pg_exec($sqltexto);
      db_fieldsmemory($resulttexto,0,true);
      $dia = date('d',strtotime($k60_datadeb));
      $mes = db_mes(date('m',strtotime($k60_datadeb)));
      $ano = date('Y',strtotime($k60_datadeb));
//---------------------------------
      $pdf->SetFont('Arial','',12);
			if (1 == 2) {
				for ($doc = 0; $doc < pg_numrows($resultdocparagr); $doc++) {
					db_fieldsmemory($resultdocparagr,$doc);

					$texto = $db02_texto;

					$imprimir= explode("#\n#",$texto);
					echo "texto: $texto<br>";
					for ($linhaimp=0; $linhaimp<sizeof($imprimir); $linhaimp++) {
						echo "   x: $linhaimp - "  . $imprimir[$linhaimp] . "<br>";
					}

				}
			}

      for ($doc = 0; $doc < pg_numrows($resultdocparagr); $doc++) {
        db_fieldsmemory($resultdocparagr,$doc);
        $texto=db_geratexto($db02_texto);

//				die("x: $texto - " . $pdf->GetStringWidth($texto));
//echo $db02_descr . "<br>";
	if (strtoupper($db02_descr) == "TOTALPORANO" and $somenteparc == false) {

	  $sqlanos = "	select case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end as k22_ano,
				    sum(k22_vlrcor) as k22_vlrcor, 
				    sum(k22_juros) as k22_juros, 
				    sum(k22_multa) as k22_multa, 
				    sum(k22_vlrcor+k22_juros+k22_multa) as k22_total 
			    from notidebitos
				    inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				    inner join arretipo on k00_tipo = k22_tipo
				    where k53_notifica = $notifica
			    group by case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end";
	  //die($sqlanos);
	  $resultanos = pg_exec($sqlanos);
	  if ($resultanos == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos! sql: '.$sqlanos);
	    exit;
	  }

	  
	  $pdf->cell(10,05,"",	             0,0,"C",0);
	  $pdf->setfillcolor(245);
	  $pdf->cell(15,05,"ANO",	     1,0,"C",1);
	  $pdf->cell(45,05,"VALOR CORRIGIDO",1,0,"C",1);
	  $pdf->cell(35,05,"JUROS",          1,0,"C",1);
	  $pdf->cell(35,05,"MULTA",          1,0,"C",1);
	  $pdf->cell(45,05,"VALOR TOTAL",    1,1,"C",1);
	  $pdf->setfillcolor(255,255,255);
	  
	  $totvlrcor=0;
	  $totjuros=0;
	  $totmulta=0;
	  $tottotal=0;
	  
	  for ($totano = 0; $totano < pg_numrows($resultanos); $totano++) {
	    db_fieldsmemory($resultanos,$totano);
	    $pdf->cell(10,05,"",	                        0,0,"C",0);
            $pdf->cell(15,05,$k22_ano,	                        1,0,"C",0);
            $pdf->cell(45,05,trim(db_formatar($k22_vlrcor,'f')),1,0,"R",0);
            $pdf->cell(35,05,trim(db_formatar($k22_juros,'f')) ,1,0,"R",0);
            $pdf->cell(35,05,trim(db_formatar($k22_multa,'f')) ,1,0,"R",0);
            $pdf->cell(45,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);

	    $totvlrcor+=$k22_vlrcor;
	    $totjuros+=$k22_juros;
	    $totmulta+=$k22_multa;
	    $tottotal+=$k22_total;

	  }
	  $pdf->setfillcolor(245);
	  $pdf->cell(25,05,"",                               0,0,"L",0);
	  $pdf->cell(45,05,trim(db_formatar($totvlrcor,'f')),1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($totjuros,'f')) ,1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($totmulta,'f')) ,1,0,"R",1);
	  $pdf->cell(45,05,trim(db_formatar($tottotal,'f')) ,1,1,"R",1);
	  $pdf->setfillcolor(255,255,255);

	} elseif (strtoupper($db02_descr) == "TOTALPORANOCOMRECIBO") {

    if ($somenteparc == false and $somenteiptu == false) {
          
			$sqlanos = "	select case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end as k22_ano,
							sum(k22_vlrcor) as k22_vlrcor, 
							sum(k22_juros) as k22_juros, 
							sum(k22_multa) as k22_multa, 
							sum(k22_vlrcor+k22_juros+k22_multa) as k22_total 
						from notidebitos
							inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
							inner join arretipo on k00_tipo = k22_tipo
							where k53_notifica = $notifica
						group by case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end";
			$resultanos = pg_exec($sqlanos) or die($sqlanos);
			if ($resultanos == false) {
				db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos! sql: '.$sqlanos);
				exit;
			}

						/*
			$pdf->cell(10,05,"",	             0,0,"C",0);
			$pdf->setfillcolor(245);
			$pdf->cell(15,05,"ANO",	     1,0,"C",1);
			$pdf->cell(45,05,"VALOR CORRIGIDO",1,0,"C",1);
			$pdf->cell(35,05,"JUROS",          1,0,"C",1);
			$pdf->cell(35,05,"MULTA",          1,0,"C",1);
			$pdf->cell(45,05,"VALOR TOTAL",    1,1,"C",1);
			$pdf->setfillcolor(255,255,255);
			*/ 
			
			$totvlrcor=0;
			$totjuros=0;
			$totmulta=0;
			$tottotal=0;

			$descranos = "";
			
			for ($totano = 0; $totano < pg_numrows($resultanos); $totano++) {
				db_fieldsmemory($resultanos,$totano);

				$descranos .= $k22_ano . ($totano != pg_numrows($resultanos) -1?",":".");
				/*
				$pdf->cell(10,05,"",	                        0,0,"C",0);
							$pdf->cell(15,05,$k22_ano,	                        1,0,"C",0);
							$pdf->cell(45,05,trim(db_formatar($k22_vlrcor,'f')),1,0,"R",0);
							$pdf->cell(35,05,trim(db_formatar($k22_juros,'f')) ,1,0,"R",0);
							$pdf->cell(35,05,trim(db_formatar($k22_multa,'f')) ,1,0,"R",0);
							$pdf->cell(45,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);
				*/

				$totvlrcor+=$k22_vlrcor;
				$totjuros+=$k22_juros;
				$totmulta+=$k22_multa;
				$tottotal+=$k22_total;

			}

    } elseif ($somenteparc == false and $somenteiptu == true) {
          
			$sqlanos = "	select case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end as k22_ano,
													 k22_numpar,
													 count(*)
						from notidebitos
							inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
							inner join arretipo on k00_tipo = k22_tipo
							where k53_notifica = $notifica
						group by case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end,
										 k22_numpar";
			$resultanos = pg_exec($sqlanos) or die($sqlanos);
			if ($resultanos == false) {
				db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos! sql: '.$sqlanos);
				exit;
			}

			$descranos = "";
			$descricao = "";
			$relanos 	 = 0;
			
			for ($totano = 0; $totano < pg_numrows($resultanos); $totano++) {
				db_fieldsmemory($resultanos,$totano);

        if ($descricao != $k00_descr) {
					$descranos .= ($descranos == ""?"":" / ") . $k00_descr . ": ";
					$descricao = $k00_descr;
				}

        if ($relanos != $k22_ano) {
  				$descranos .= $k22_ano . "- PARC: ";
					$relanos = $k22_ano;
				}

				$descranos .= $k22_numpar . "-";

			}

		} else {

			$sqlanos = "select  arretipo.k00_descr,
													v07_parcel,
													k22_numpar,
													count(*)
						from notidebitos
							inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
							inner join arretipo on k00_tipo = k22_tipo
							inner join termo on termo.v07_numpre = debitos.k22_numpre
							where k53_notifica = $notifica
							group by 	arretipo.k00_descr,
												v07_parcel,
												k22_numpar
							order by  arretipo.k00_descr,
												v07_parcel,
												k22_numpar";
			$resultanos = pg_exec($sqlanos) or die($sqlanos);
			if ($resultanos == false) {
				db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos! sql: '.$sqlanos);
				exit;
			}

			$descranos = "";
			$descricao = "";
			$parcel = 0;
			
			for ($totano = 0; $totano < pg_numrows($resultanos); $totano++) {
				db_fieldsmemory($resultanos,$totano);

        if ($descricao != $k00_descr) {
					$descranos .= ($descranos == ""?"":" / ") . $k00_descr . ": ";
					$descricao = $k00_descr;
				}

        if ($parcel != $v07_parcel) {
  				$descranos .= $v07_parcel . "- PARC: ";
					$parcel = $v07_parcel;
				}

				$descranos .= $k22_numpar . "-";

			}

		}
	  
	  /*
	  $pdf->setfillcolor(245);
	  $pdf->cell(25,05,"",                               0,0,"L",0);
	  $pdf->cell(45,05,trim(db_formatar($totvlrcor,'f')),1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($totjuros,'f')) ,1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($totmulta,'f')) ,1,0,"R",1);
	  $pdf->cell(45,05,trim(db_formatar($tottotal,'f')) ,1,1,"R",1);
	  $pdf->setfillcolor(255,255,255);
	  */
	  $sqltipodebito = "	select distinct k22_tipo as tipo_debito
			    from notidebitos
				    inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				    inner join arretipo on k00_tipo = k22_tipo
				    where k53_notifica = $notifica
						order by k22_tipo";
	  $resulttipodebito = pg_exec($sqltipodebito) or die($sqltipodebito);
	  if ($resulttipodebito == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar select do recibo! sql: '.$sqltipodebito);
	    exit;
	  }
		db_fieldsmemory($resulttipodebito, 0);

	  $sqlrecibo = "	select distinct k53_numpre, k53_numpar
			    from notidebitos
				    inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				    inner join arretipo on k00_tipo = k22_tipo
				    where k53_notifica = $notifica";
	  $resultrecibo = pg_exec($sqlrecibo) or die($sqlrecibo);
	  if ($resultrecibo == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar select do recibo! sql: '.$sqlanos);
	    exit;
	  }





    $cadtipoparc = 0;

    $sqltipoparc = "select 	* 
    				from tipoparc 
    				inner join cadtipoparc 
				on cadtipoparc = k40_codigo
				where maxparc = 1 and '"
				. date("Y-m-d",db_getsession("DB_datausu")) . "' >= k40_dtini and 
				'" . date("Y-m-d",db_getsession("DB_datausu")) . "' <= k40_dtfim";
    $resulttipoparc = pg_exec($sqltipoparc);
    if (pg_numrows($resulttipoparc) > 0) {
      db_fieldsmemory($resulttipoparc,0);
    } else {
      $k40_todasmarc = false;
    }

    $sqltipoparcdeb = "select * from cadtipoparcdeb limit 1";
    $resulttipoparcdeb = pg_exec($sqltipoparcdeb);
    $passar = false;
    if (pg_numrows($resulttipoparcdeb) == 0) {
      $passar = true;
    } else {
      $sqltipoparcdeb = "select * from cadtipoparcdeb where k41_cadtipoparc = $cadtipoparc and k41_arretipo = $tipo_debito";
      $resulttipoparcdeb = pg_exec($sqltipoparcdeb);
      if (pg_numrows($resulttipoparcdeb) > 0) {
        $passar = true;
      }
    }




    if (pg_numrows($resulttipoparc) == 0 or $passar == false) {
      $desconto = 0;
    } else {
      $desconto = $k40_codigo;
    }




		

	  $resultnumpre = pg_exec("select nextval('numpref_k03_numpre_seq') as k03_numpre") or die("erro na numpref_k03_numpre_seq");
	  db_fieldsmemory($resultnumpre,0);

		$fc_numbco 	= "";
	  $k00_codbco 	= 0;
	  $k00_codage 	= "";

	  for ($regrecibo = 0; $regrecibo < pg_numrows($resultrecibo); $regrecibo++) {
	    db_fieldsmemory($resultrecibo, $regrecibo);
	    $sql = "insert into db_reciboweb values(".$k53_numpre.",".$k53_numpar.",$k03_numpre,$k00_codbco,'$k00_codage','$fc_numbco',$desconto)";
//	    echo $sql . ";<br>";
	    pg_exec($sql) or die("Erro(26) inserindo em db_reciboweb: ".pg_errormessage()); 
	  }
	  //roda funcao fc_recibo pra gerar o recibo
	  $sql = "select fc_recibo($k03_numpre,'" . $db_datausu . "','".db_vencimento()."',".db_getsession("DB_anousu").")";
	  $recibo = pg_exec($sql) or die($sql);
//	    echo $sql . ";<br>";exit;






	  $sql = "select r.k00_numcgm,r.k00_receit,
			 case when taborc.k02_codigo is null then tabplan.k02_reduz else taborc.k02_codrec end as codreduz
			 ,t.k02_descr,t.k02_drecei,r.k00_dtoper as k00_dtoper,sum(r.k00_valor) as valor
			   from recibopaga r
			   inner join tabrec t on t.k02_codigo = r.k00_receit 
			   inner join tabrecjm on tabrecjm.k02_codjm = t.k02_codjm
			   left outer join taborc  on t.k02_codigo = taborc.k02_codigo and taborc.k02_anousu = ".db_getsession("DB_anousu")."
			   left outer join tabplan  on t.k02_codigo = tabplan.k02_codigo and tabplan.k02_anousu = ".db_getsession("DB_anousu")."
			   where r.k00_numnov = ".$k03_numpre."
			   group by r.k00_dtoper,r.k00_receit,t.k02_descr,t.k02_drecei,r.k00_numcgm,codreduz";
	  $DadosPagamento = pg_exec($sql) or die($sql);
	  //faz um somatorio do valor
	  //db_criatabela($DadosPagamento);exit;
	  $datavencimento = pg_result($DadosPagamento,0,"k00_dtoper");
	  $total_recibo = 0;
	  for($i = 0;$i < pg_numrows($DadosPagamento);$i++) {
	    $total_recibo += pg_result($DadosPagamento,$i,"valor");
	  }

	  //seleciona da tabela db_config, o numero do banco e a taxa bancaria e concatena em variavel
	  $sqlinstit = "select nomeinst,ender,munic,email,telef,uf,logo,to_char(tx_banc,'9.99') as tx_banc,numbanco from db_config where codigo = ".db_getsession("DB_instit");
	  $DadosInstit = pg_exec($sqlinstit) or die($sqlinstit);
	  //cria codigo de barras e linha digitável
	  $NumBanco = pg_result($DadosInstit,0,"numbanco");
	  $taxabancaria = pg_result($DadosInstit,0,"tx_banc");
	  $src = pg_result($DadosInstit,0,'logo');
	  $db_nomeinst = pg_result($DadosInstit,0,'nomeinst');
	  $db_ender    = pg_result($DadosInstit,0,'ender');
	  $db_munic    = pg_result($DadosInstit,0,'munic');
	  $db_uf       = pg_result($DadosInstit,0,'uf');
	  $db_telef    = pg_result($DadosInstit,0,'telef');
	  $db_email    = pg_result($DadosInstit,0,'email');

	  $total_recibo += $taxabancaria;
	  if ( $total_recibo == 0 ){
	     db_redireciona('db_erros.php?fechar=true&db_erro=O Recibo Com Valor Zerado.');
	  }
	  $valor_parm = $total_recibo; 



	  //seleciona dados de identificacao. Verifica se é inscr ou matric e da o respectivo select
	  //essa variavel vem do cai3_gerfinanc002.php, pelo window open, criada por parse_str
	  if ($k60_tipo == 'M'){
	    $numero = $matric;
	    $tipoidentificacao = "Matricula :";
	    $sqlIdentificacao = "select z01_nome,z01_ender,z01_numero,z01_compl,z01_munic,z01_uf,z01_cep,nomepri,j39_compl,j39_numero,j13_descr,j34_setor||'.'||j34_quadra||'.'||j34_lote as sql,z01_cgccpf
			       from proprietario
						   where j01_matric = $numero limit 1";
	    $Identificacao = pg_exec($sqlIdentificacao) or die($sqlIdentificacao);
	    db_fieldsmemory($Identificacao,0);
	    $ident_tipo_ii = 'Imóvel';
	  } elseif ($k60_tipo == 'I') {
	    $numero = $q02_inscr;
	    $tipoidentificacao = "Inscricao :";
//	    $Identificacao = pg_exec("select z01_nome,
//					     z01_ender,
//					     z01_numero,
//					     z01_compl,
//					     z01_munic,
//					     z01_uf,
//					     z01_cep,
//					     z01_ender as nomepri,
//					     z01_compl as j39_compl,
//					     z01_numero as j39_numero,
//					     z01_bairro as j13_descr, 
//					     '' as sql,
//					     z01_cgccpf  
//				      from empresa
//					     where q02_inscr = $numero");
	    $sqlidentificacao = "select 	   cgm.z01_nome,
					     cgm.z01_ender,
					     cgm.z01_numero,
					     cgm.z01_compl,
					     cgm.z01_munic,
					     cgm.z01_uf,
					     cgm.z01_cep,
					     empresa.z01_ender as nomepri,
					     empresa.z01_compl as j39_compl,
					     empresa.z01_numero as j39_numero,
					     empresa.z01_bairro as j13_descr, 
					     '' as sql,
					     cgm.z01_cgccpf  
				      from issbase
					  inner join empresa on issbase.q02_inscr = empresa.q02_inscr
					  inner join cgm on issbase.q02_numcgm = cgm.z01_numcgm
					     where issbase.q02_inscr = $numero";
	    $Identificacao = pg_exec($sqlidentificacao) or die($sqlidentificacao);

	  /*

			       select cgm.z01_nome,cgm.z01_ender,cgm.z01_munic,cgm.z01_uf,cgm.z01_cep,c.j14_nome as nomepri,i.q02_compl as j39_compl,i.q02_numero as j39_numero,j13_descr, '' as sql  
			       from cgm
						   inner join issbase i 
						       on i.q02_numcgm = cgm.z01_numcgm
						   left outer join ruas c 
						       on c.j14_codigo = i.q02_lograd 
						   left outer join bairro b 
						      on b.j13_codi = i.q02_bairro 
						   where i.q02_inscr = ".$HTTP_POST_VARS["ver_inscr"]);
	  */
	    $ident_tipo_ii = 'Alvará';
	    db_fieldsmemory($Identificacao,0);
	  } else {
	    $numero = $cgm;
	    $tipoidentificacao = "Numcgm :";
	    $sqlIdentificacao = "select z01_nome,z01_ender,z01_numero,z01_compl,z01_munic,z01_uf,z01_cep,''::bpchar as nomepri,''::bpchar as j39_compl,''::bpchar as j39_numero,z01_bairro as j13_descr, '' as sql, z01_cgccpf
			       from cgm
						   where z01_numcgm = $numero ";
	    $Identificacao = pg_exec($sqlIdentificacao) or die($sqlIdentificacao);
	    db_fieldsmemory($Identificacao,0);
	    $ident_tipo_ii = '';
	  }



		$k00_descr 		= "";
    if ($somenteparc == false and $somenteiptu == false) {
			$historico		= $descrtipo . " - " . $descranos;
    } elseif ($somenteparc == false and $somenteiptu == true) {
  	  $historico		= $descranos;
		} else {
  	  $historico		= $descranos;
		}





	  //select pras observacoes
	  $Observacoes = pg_exec($conn,"select mens,alinhamento from db_confmensagem where cod in('obsboleto1','obsboleto2','obsboleto3','obsboleto4')");
	  $db_vlrbar = db_formatar(str_replace('.','',str_pad(number_format($total_recibo,2,"","."),11,"0",STR_PAD_LEFT)),'s','0',11,'e');

          $sqlnumbco = "select numbanco, segmento, formvencfebraban from db_config where codigo = " . db_getsession("DB_instit");
	  $resultnumbco = pg_exec($sqlnumbco) or die($sqlnumbco);
	  db_fieldsmemory($resultnumbco,0) ;// deve ser tirado do db_config

	  $db_numpre = db_numpre($k03_numpre).'000'; //db_formatar(0,'s',3,'e');


	  if ($formvencfebraban == 1) {
	    $db_dtvenc = str_replace("-","",$datavencimento);
	    $vencbar = $db_dtvenc . '000000';
	  } elseif ($formvencfebraban == 2) {
	    $db_dtvenc = str_replace("-","",$datavencimento);
	    $db_dtvenc = substr($db_dtvenc,6,2) . substr($db_dtvenc,4,2) . substr($db_dtvenc,2,2);
	    $vencbar = $db_dtvenc . '00000000';
	  }


	  //db_msgbox($tipo_debito);exit;
	   $sqlvalor = "select k00_tercdigrecnormal from arretipo where k00_tipo = 1";
	   // acertar
	   $resultvalor = pg_exec($sqlvalor) or die($sqlvalor);
	   db_fieldsmemory($resultvalor,0);
	   if(!isset($k00_tercdigrecnormal) || $k00_tercdigrecnormal == ""){
	       db_redireciona('db_erros.php?fechar=true&db_erro=Configure o terceiro digito do codigo de barras no cadastro do tipo de debito para este tipo de debito.');
	   }

	  $inibar="8" . $segmento . $k00_tercdigrecnormal;
	  $sqlcod = "select fc_febraban('$inibar'||'$db_vlrbar'||'".$numbanco."'||'".$vencbar."'||'$db_numpre')";
	  $resultcod = pg_exec($sqlcod) or die($sqlcod);
	  db_fieldsmemory($resultcod,0);

	  if ($fc_febraban == "") {
	    db_msgbox("Erro ao gerar codigo de barras (3)!");
	    exit;
	  }

	  $codigo_barra = explode(",",$fc_febraban);
	  $codigobarras = $codigo_barra[0];
	  $linhadigitavel = $codigo_barra[1];

	  $datavencimento = db_formatar($datavencimento,"d");

	  //numpre formatado
	  $numpre = db_sqlformatar($k03_numpre,8,'0').'000999';
	  $numpre = $numpre . db_CalculaDV($numpre,11);




















	  $pdf->logo 		= 'logo_boleto.png';
	  $pdf->prefeitura 	= $db_nomeinst;
	  $pdf->enderpref	= $db_ender;
	  $pdf->municpref	= $db_munic;
	  $pdf->telefpref	= $db_telef;
	  $pdf->emailpref	= @$db_email;
	  $pdf->nome		= trim(pg_result($Identificacao,0,"z01_nome"));
	  $pdf->ender		= trim(pg_result($Identificacao,0,"z01_ender")).', '.pg_result($Identificacao,0,"z01_numero").' '.trim(pg_result($Identificacao,0,"z01_compl"));
	  $pdf->munic		= trim(pg_result($Identificacao,0,"z01_munic"));
	  $pdf->cep		= trim(pg_result($Identificacao,0,"z01_cep"));
	  $pdf->cgccpf		= trim(@pg_result($Identificacao,0,"z01_cgccpf"));
	  $pdf->tipoinscr	= $tipoidentificacao;
	  $pdf->nrinscr		= $numero;
	  $pdf->ip	    	= db_getsession("DB_ip");



	  $pdf->identifica_dados = $ident_tipo_ii;

	  $pdf->tipolograd 	 = 'Logradouro:';
	  $pdf->nomepri		 = $nomepri;
	  $pdf->tipocompl    	 = 'Número:';
	  $pdf->nrpri		 = $j39_numero;
	  $pdf->complpri	 = $j39_compl;
	  $pdf->tipobairro  	 = 'Bairro:';
	  $pdf->bairropri	 = $j13_descr;
	  $pdf->datacalc	 = date('d-m-Y',$DB_DATACALC);
	  $pdf->taxabanc	 = db_formatar($taxabancaria,'f');
	  $pdf->recorddadospagto = $DadosPagamento;
	  $pdf->linhasdadospagto = pg_numrows($DadosPagamento);
	  $pdf->receita		 = 'k00_receit';
	  $pdf->receitared	 = 'codreduz';
	  $pdf->dreceita 	 = 'k02_descr';
	  $pdf->ddreceita	 = 'k02_drecei';
	  $pdf->valor 		 = 'valor';
	  $pdf->historico	 = $k00_descr;
	  $pdf->historico	 = $historico;
	  $pdf->histparcel	 = @$histparcela;
	  $pdf->dtvenc		 = $datavencimento;
	  $pdf->numpre		 = $numpre;
	  $pdf->valtotal	 = db_formatar(@$valor_parm,'f');
	  $pdf->linhadigitavel	 = $linhadigitavel;
	  $pdf->codigobarras	 = $codigobarras;
	  $pdf->texto     	 = db_getsession('DB_login').' - '.date("d-m-Y - H-i").'   '.db_base_ativa();

	  $pdf->descr3_1  = trim(pg_result($Identificacao,0,"z01_nome")); // contribuinte
	  $pdf->descr3_2  = trim(pg_result($Identificacao,0,"z01_ender")).', '.pg_result($Identificacao,0,"z01_numero").' '.trim(pg_result($Identificacao,0,"z01_compl"));// endereco
	  $pdf->bairropri = $j13_descr;    // municipio
	  $pdf->munic     = trim(pg_result($Identificacao,0,"z01_munic"));    // bairro

	  $pdf->cep		 = trim(pg_result($Identificacao,0,"z01_cep"));
	  $pdf->cgccpf    = trim(@pg_result($Identificacao,0,"z01_cgccpf"));

	  $pdf->titulo5 = "";                 // titulo parcela
	  $pdf->descr5  = "";                 // descr parcela
	  $pdf->titulo8 = $tipoidentificacao;  // tipo de identificacao;
	  $pdf->descr8  = $numero;            //descr matricula ou inscricao


    if (1 == 2) {
			$sqlReceitas = "select k00_receit      as codreceita,
									 k02_descr       as descrreceita,
									 sum(k00_valor)  as valreceita,
						 case when taborc.k02_codigo is not null then 
					 taborc.k02_codrec 
					else 
						 tabplan.k02_reduz
						 end as reduzreceita
				from recibopaga
							 inner join tabrec  on tabrec.k02_codigo   = recibopaga.k00_receit
						 left  join taborc  on tabrec.k02_codigo   = taborc.k02_codigo
									 and taborc.k02_anousu   = ".db_getsession('DB_anousu')."
						 left  join tabplan on tabrec.k02_codigo   = tabplan.k02_codigo
									 and tabplan.k02_anousu  = ".db_getsession('DB_anousu')."
							where k00_numnov = $k03_numpre
							group by k00_receit,
									 k02_descr,
									 taborc.k02_codrec,
									 tabplan.k02_reduz,
									 taborc.k02_codigo";
			$rsReceitas = pg_query($sqlReceitas) or die($sqlReceitas);
			$intnumrows = pg_num_rows($rsReceitas);
			for($x=0;$x<$intnumrows;$x++){
				 db_fieldsmemory($rsReceitas,$x);
				 $pdf->arraycodreceitas[$x]   = $codreceita;
				 $pdf->arrayreduzreceitas[$x] = $reduzreceita;
				 $pdf->arraydescrreceitas[$x] = $descrreceita;
				 $pdf->arrayvalreceitas[$x]   = $valreceita;
			}

	  }
		
    if (1 == 1) {

	  $pdf->descr4_1  = $historico;
	  $pdf->descr4_2  = ""; // historico - linha 1
	  $pdf->descr16_1 = "";
	  $pdf->descr16_2 = "";
	  $pdf->descr16_3 = ""; // 

	  $pdf->descr12_1 = "";
	  $pdf->descr12_2 = ""; // 

	  $pdf->linha_digitavel = $linhadigitavel;
	  $pdf->codigo_barras   = $codigobarras;
	  
	  $pdf->descr6 = $datavencimento;  // Data de Vencimento
	  $pdf->descr7 = db_formatar(@$valor_parm,'f');  // qtd de URM ou valor
	  $pdf->descr9 = $numpre; // cod. de arrecadação















        //// RECIBO
  $pdf->sety(155);
//	die("xxx: " . $pdf->gety() . "\n");
	$linha = $pdf->gety() + 30;
	$linha = $pdf->gety();
	$pdf->ln(5);
	$pdf->line(2,$linha,208,$linha);
	$xlin = $linha + 20;
	$xcol = 4;
       	for ($i = 0;$i < 2;$i++) {
		$pdf->setfillcolor(245);
		$pdf->roundedrect($xcol-2,$xlin-18,206,65,2,'DF','1234');
		$pdf->setfillcolor(255,255,255);
		$pdf->Setfont('Arial','B',11);
		$pdf->text(150,$xlin-13,'RECIBO VÁLIDO ATÉ: ');
		$pdf->text(159,$xlin-8,$pdf->datacalc);
		
		//Via
		if( $i == 0 ){
		  $str_via = 'Contribuinte';
		}else{
		  $str_via = 'Prefeitura';
		}
		$pdf->Setfont('Arial','B',8);
		$pdf->text(178,$xlin-1,($i+1).'ª Via '.$str_via );
	
		$pdf->Image('imagens/files/'.$pdf->logo,15,$xlin-17,12);
		$pdf->Setfont('Arial','B',9);
		$pdf->text(40,$xlin-15,$pdf->prefeitura);
		$pdf->Setfont('Arial','',9);
		$pdf->text(40,$xlin-11,$pdf->enderpref);
		$pdf->text(40,$xlin-8,$pdf->municpref);
		$pdf->text(40,$xlin-5,$pdf->telefpref);
		$pdf->text(40,$xlin-2,$pdf->emailpref);
	
		$pdf->Roundedrect($xcol,$xlin+2,$xcol+119,20,2,'DF','1234');
		$pdf->Setfont('Arial','',6);
		$pdf->text($xcol+2,$xlin+4,'Identificação:');
		$pdf->Setfont('Arial','',8);
		$pdf->text($xcol+2,$xlin+7,'Nome :');
		$pdf->text($xcol+17,$xlin+7,$pdf->nome);
		$pdf->text($xcol+2,$xlin+11,'Endereço :');
		$pdf->text($xcol+17,$xlin+11,$pdf->ender);
		$pdf->text($xcol+2,$xlin+15,'Município :');
		$pdf->text($xcol+17,$xlin+15,$pdf->munic);
		$pdf->text($xcol+75,$xlin+15,'CEP :');
		$pdf->text($xcol+82,$xlin+15,$pdf->cep);
		$pdf->text($xcol+2,$xlin+19,'Data :');

		
                $pdf->text($xcol+17,$xlin+19, date("d-m-Y",db_getsession("DB_datausu")));

		$pdf->text($xcol+40,$xlin+19,'Hora: '.date("H:i:s"));

		$pdf->text($xcol+75,$xlin+19,'CNPJ/CPF:');
		$pdf->text($xcol+90,$xlin+19,db_formatar($pdf->cgccpf,(strlen($pdf->cgccpf)<12?'cpf':'cnpj')));
		
		$pdf->Setfont('Arial','',6);
	
		$pdf->Roundedrect($xcol+126,$xlin+2,76,20,2,'DF','1234');
		
		$pdf->text($xcol+128,$xlin+4,$pdf->identifica_dados);
		
		$pdf->text($xcol+128,$xlin+7,$pdf->tipoinscr);
		$pdf->text($xcol+145,$xlin+7,$pdf->nrinscr);
		
		$pdf->text($xcol+128,$xlin+11,$pdf->tipolograd);
		$pdf->text($xcol+145,$xlin+11,$pdf->nomepri);
		$pdf->text($xcol+128,$xlin+15,$pdf->tipocompl);
		$pdf->text($xcol+145,$xlin+15,$pdf->nrpri."      ".$pdf->complpri);
		$pdf->text($xcol+128,$xlin+19,$pdf->tipobairro);
		$pdf->text($xcol+145,$xlin+19,$pdf->bairropri);

                if ($i == 0) {

		  $pdf->Roundedrect($xcol,$xlin+25,202,20,2,'DF','1234');
		  $pdf->SetY($xlin+26);
		  $pdf->SetX($xcol+3);
		  $pdf->multicell(0,4,'HISTÓRICO :   '.$pdf->historico);
		  $pdf->SetX($xcol+3);

		  $pdf->Setfont('Arial','',6);
		  $pdf->setx(15);

		  $pdf->Roundedrect(125,$xlin+30,21,10,2,'DF','1234');
		  $pdf->Roundedrect(173,$xlin+30,32,10,2,'DF','1234');
		  $pdf->Roundedrect(147,$xlin+30,25,10,2,'DF','1234');
		  $pdf->text(129,$xlin+32,'Vencimento');
		  $pdf->text(179,$xlin+32,'Código de Arrecadação');
		  $pdf->text(150,$xlin+32,'Valor a Pagar em R$');
		  $pdf->setfont('Arial','',10);
		  $pdf->text(127,$xlin+37,$pdf->dtvenc);
		  $pdf->text(175,$xlin+37,$pdf->numpre);
		  $pdf->text(150,$xlin+37,$pdf->valtotal);

		} else {

		  $pdf->Setfont('Arial','',6);
		  $pdf->setx(15);

		  $pdf->Roundedrect(126,$xlin+24,21,10,2,'DF','1234');
		  $pdf->Roundedrect(174,$xlin+24,32,10,2,'DF','1234');
		  $pdf->Roundedrect(148,$xlin+24,25,10,2,'DF','1234');
		  $pdf->text(130,$xlin+26,'Vencimento');
		  $pdf->text(180,$xlin+26,'Código de Arrecadação');
		  $pdf->text(151,$xlin+26,'Valor a Pagar em R$');
		  $pdf->setfont('Arial','',10);
		  $pdf->text(128,$xlin+31,$pdf->dtvenc);
		  $pdf->text(176,$xlin+31,$pdf->numpre);
		  $pdf->text(151,$xlin+31,$pdf->valtotal);

		  $pdf->SetFont('Arial','B',5);
		  $pdf->text(140,$xlin+36,"A   U   T   E   N   T   I   C   A   Ç   Ã   O      M   E   C   Â   N   I   C   A");

		  $pdf->setfillcolor(0,0,0);
		  $pdf->SetFont('Arial','',4);
		  $pdf->TextWithDirection(1.5,$xlin+28,$pdf->texto,'U'); // texto no canhoto do carne
		  $pdf->setfont('Arial','',11);
		  $pdf->text(10,$xlin+28,$pdf->linhadigitavel);
		  
		  $pdf->int25(10,$xlin+31,$pdf->codigobarras,15,0.341);

		}
		
	        $xlin += 67;
       }

//       $pdf->sety(120);
 //      $pdf->addpage();


  }


























































	  

	} elseif (strtoupper($db02_descr) == "TOTALPORANO" and $somenteparc == true) {

	  $sqlanos = "	select count(*) as k22_numpar, sum(k22_total) as k22_total from (
						select k22_numpar, sum(k22_vlrcor+k22_juros+k22_multa) as k22_total
			    from notidebitos
				    inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				    inner join arretipo on k00_tipo = k22_tipo
				    where k53_notifica = $notifica
			    group by k22_numpar) as x";
	  $resultanos = pg_exec($sqlanos) or die($sql);
	  if ($resultanos == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos! sql: '.$sqlanos);
	    exit;
	  }

	  $pdf->setfillcolor(245);
	  $pdf->cell(30,05,"",	             0,0,"C",0);
	  $pdf->cell(30,05,"PARCELAS",	     1,0,"C",1);
	  $pdf->cell(45,05,"VALOR TOTAL",    1,1,"C",1);
	  $pdf->setfillcolor(255,255,255);
	  
		db_fieldsmemory($resultanos, 0);
		$pdf->cell(30,05,"",	                              0,0,"C",0);
		$pdf->cell(30,05,$k22_numpar,	                      1,0,"C",0);
		$pdf->cell(45,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);

	} elseif (strtoupper($db02_descr) == "TOTALGERALPORANO" and $somenteparc == false) {


	  $sqlanostipos = "	select case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end as k22_ano,
				    sum(k22_vlrcor) as k22_vlrcor, 
				    sum(k22_juros) as k22_juros, 
				    sum(k22_multa) as k22_multa, 
				    sum(k22_vlrcor+k22_juros+k22_multa) as k22_total 
				    from debitos
				    inner join arretipo on k00_tipo = k22_tipo
				    " . ($tipos == ""?"":" and k22_tipo in ($tipos)") .
				    " and $xmatinsc22
				    k22_data = '$k60_datadeb'
            where k22_dtvenc < '$k60_datadeb'
			    group by case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end";

//          die("sql: $sqlanostipos\n");

	  $resultanostipos = pg_exec($sqlanostipos);
	  if ($resultanostipos == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos dos tipos selecionados! sql: '.$sqlanostipos);
	    exit;
	  }
	  

	  $pdf->cell(10,05,"",	             0,0,"C",0);
	  $pdf->setfillcolor(245);
	  $pdf->cell(15,05,"ANO",	     1,0,"C",1);
	  $pdf->cell(45,05,"VALOR CORRIGIDO",1,0,"C",1);
	  $pdf->cell(35,05,"JUROS",          1,0,"C",1);
	  $pdf->cell(35,05,"MULTA",          1,0,"C",1);
	  $pdf->cell(45,05,"VALOR TOTAL",    1,1,"C",1);
	  $pdf->setfillcolor(255,255,255);
	  
	  $totvlrcor=0;
	  $totjuros=0;
	  $totmulta=0;
	  $tottotal=0;
	  
	  for ($totano = 0; $totano < pg_numrows($resultanostipos); $totano++) {
	    db_fieldsmemory($resultanostipos,$totano);
	    $pdf->cell(10,05,"",	                        0,0,"C",0);
            $pdf->cell(15,05,$k22_ano,	                        1,0,"C",0);
            $pdf->cell(45,05,trim(db_formatar($k22_vlrcor,'f')),1,0,"R",0);
            $pdf->cell(35,05,trim(db_formatar($k22_juros,'f')) ,1,0,"R",0);
            $pdf->cell(35,05,trim(db_formatar($k22_multa,'f')) ,1,0,"R",0);
            $pdf->cell(45,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);

	    $totvlrcor+=$k22_vlrcor;
	    $totjuros+=$k22_juros;
	    $totmulta+=$k22_multa;
	    $tottotal+=$k22_total;

	  }
	  $pdf->setfillcolor(245);
	  $pdf->cell(25,05,"",                               0,0,"L",0);
	  $pdf->cell(45,05,trim(db_formatar($totvlrcor,'f')),1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($totjuros,'f')) ,1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($totmulta,'f')) ,1,0,"R",1);
	  $pdf->cell(45,05,trim(db_formatar($tottotal,'f')) ,1,1,"R",1);
	  $pdf->setfillcolor(255,255,255);

	} elseif (strtoupper($db02_descr) == "TOTALGERALPORANO" and $somenteparc == true) {

	  $sqlparcelas = " select count(*) as k22_numpar, sum(k22_total) as k22_total from (
											select k22_numpar, sum(k22_vlrcor+k22_juros+k22_multa) as k22_total
											from debitos
											inner join arretipo on k00_tipo = k22_tipo
											" . ($tipos == ""?"":" and k22_tipo in ($tipos)") .
											" and $xmatinsc22
											k22_data = '$k60_datadeb'
											where k22_dtvenc < '$k60_datadeb'
											group by k22_numpar) as x";
	  $resultparcelas = pg_exec($sqlparcelas);
	  if ($resultparcelas == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar parcelas! sql: '.$sqlanostipos);
	    exit;
	  }

	  $pdf->setfillcolor(245);
	  $pdf->cell(30,05,"",	             0,0,"C",0);
	  $pdf->cell(30,05,"PARCELAS",	     1,0,"C",1);
	  $pdf->cell(45,05,"VALOR TOTAL",    1,1,"C",1);
	  $pdf->setfillcolor(255,255,255);
	  
		db_fieldsmemory($resultparcelas,0);
		$pdf->cell(30,05,"",	                              0,0,"C",0);
		$pdf->cell(30,05,$k22_numpar,	                      1,0,"C",0);
		$pdf->cell(45,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);

	} elseif (strtoupper($db02_descr) == "TOTALPORANOETIPO") {


	  $sqlanostiposdeb = "	select 	
				    case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end as k22_ano,
				    k00_descr,
				    sum(k22_vlrcor) as k22_vlrcor, 
				    sum(k22_juros) as k22_juros, 
				    sum(k22_multa) as k22_multa, 
				    sum(k22_vlrcor+k22_juros+k22_multa) as k22_total 
			    from notidebitos
				    inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				    inner join arretipo on k00_tipo = k22_tipo
				    where k53_notifica = $notifica
			    group by 
					case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end,
				     k00_descr";
	  //die($sqlanostiposdeb);
	  $resultanostiposdeb = pg_exec($sqlanostiposdeb);
	  if ($resultanostiposdeb == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos dos tipos selecionados! sql: ' . $sqlanostiposdeb);
	    exit;
	  }



	  $pdf->setfillcolor(245);
	  $pdf->cell(15,05,"ANO",	     1,0,"C",1);
	  $pdf->cell(50,05,"TIPO DE DEBITO", 1,0,"C",1);
	  $pdf->cell(35,05,"VLR CORRIGIDO",1,0,"C",1);
	  $pdf->cell(25,05,"JUROS",          1,0,"C",1);
	  $pdf->cell(25,05,"MULTA",          1,0,"C",1);
	  $pdf->cell(35,05,"VLR TOTAL",    1,1,"C",1);
	  $pdf->setfillcolor(255,255,255);
	  
	  $totvlrcor=0;
	  $totjuros=0;
	  $totmulta=0;
	  $tottotal=0;
	  
	  for ($totano = 0; $totano < pg_numrows($resultanostiposdeb); $totano++) {
	    db_fieldsmemory($resultanostiposdeb,$totano);
            $pdf->cell(15,05,$k22_ano,	                        1,0,"C",0);
            $pdf->cell(50,05,$k00_descr,	                1,0,"C",0);
            $pdf->cell(35,05,trim(db_formatar($k22_vlrcor,'f')),1,0,"R",0);
            $pdf->cell(25,05,trim(db_formatar($k22_juros,'f')) ,1,0,"R",0);
            $pdf->cell(25,05,trim(db_formatar($k22_multa,'f')) ,1,0,"R",0);
            $pdf->cell(35,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);

	    $totvlrcor+=$k22_vlrcor;
	    $totjuros+=$k22_juros;
	    $totmulta+=$k22_multa;
	    $tottotal+=$k22_total;

	  }
	  $pdf->setfillcolor(245);
	  $pdf->cell(65,05,"",                               0,0,"L",0);
	  $pdf->cell(35,05,trim(db_formatar($totvlrcor,'f')),1,0,"R",1);
	  $pdf->cell(25,05,trim(db_formatar($totjuros,'f')) ,1,0,"R",1);
	  $pdf->cell(25,05,trim(db_formatar($totmulta,'f')) ,1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($tottotal,'f')) ,1,1,"R",1);
	  $pdf->setfillcolor(255,255,255);

	} elseif (strtoupper($db02_descr) == "TOTALPORANOEHISTORICO") {


	  $sqlanoshistdeb = "	select 	
				    case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end as k22_ano,
				    k01_descr,
				    sum(k22_vlrcor) as k22_vlrcor, 
				    sum(k22_juros) as k22_juros, 
				    sum(k22_multa) as k22_multa, 
				    sum(k22_vlrcor+k22_juros+k22_multa) as k22_total 
			    from notidebitos
				    inner join debitos on k22_numpre = k53_numpre and k22_numpar = k53_numpar and k22_data = '$k60_datadeb'
				    inner join arretipo on k00_tipo = k22_tipo
				    inner join histcalc on k01_codigo = k22_hist
				    where k53_notifica = $notifica
			    group by case when k22_exerc is null then extract (year from k22_dtoper) else k22_exerc end,
				     k01_descr";
          //die($sql);
	  $resultanoshistdeb = pg_exec($sqlanoshistdeb);
	  if ($resultanoshistdeb == false) {
	    db_redireciona('db_erros.php?fechar=true&db_erro=Problemas ao gerar totais por anos dos historicos! sql: '.$sqlanoshistdeb);
	    exit;
	  }


	  $pdf->setfillcolor(245);
	  $pdf->cell(15,05,"ANO",	     1,0,"C",1);
	  $pdf->cell(50,05,"HISTORICO",      1,0,"C",1);
	  $pdf->cell(35,05,"VLR CORRIGIDO",  1,0,"C",1);
	  $pdf->cell(25,05,"JUROS",          1,0,"C",1);
	  $pdf->cell(25,05,"MULTA",          1,0,"C",1);
	  $pdf->cell(35,05,"VLR TOTAL",      1,1,"C",1);
	  $pdf->setfillcolor(255,255,255);
	  
	  $totvlrcor=0;
	  $totjuros=0;
	  $totmulta=0;
	  $tottotal=0;
	  
	  for ($totano = 0; $totano < pg_numrows($resultanoshistdeb); $totano++) {
	    db_fieldsmemory($resultanoshistdeb,$totano);
            $pdf->cell(15,05,$k22_ano,	                        1,0,"C",0);
            $pdf->cell(50,05,$k01_descr,	                1,0,"C",0);
            $pdf->cell(35,05,trim(db_formatar($k22_vlrcor,'f')),1,0,"R",0);
            $pdf->cell(25,05,trim(db_formatar($k22_juros,'f')) ,1,0,"R",0);
            $pdf->cell(25,05,trim(db_formatar($k22_multa,'f')) ,1,0,"R",0);
            $pdf->cell(35,05,trim(db_formatar($k22_total,'f')) ,1,1,"R",0);

	    $totvlrcor+=$k22_vlrcor;
	    $totjuros+=$k22_juros;
	    $totmulta+=$k22_multa;
	    $tottotal+=$k22_total;

	  }
	  
	  $pdf->setfillcolor(245);
	  $pdf->cell(65,05,"",                               0,0,"L",0);
	  $pdf->cell(35,05,trim(db_formatar($totvlrcor,'f')),1,0,"R",1);
	  $pdf->cell(25,05,trim(db_formatar($totjuros,'f')) ,1,0,"R",1);
	  $pdf->cell(25,05,trim(db_formatar($totmulta,'f')) ,1,0,"R",1);
	  $pdf->cell(35,05,trim(db_formatar($tottotal,'f')) ,1,1,"R",1);
	  $pdf->setfillcolor(255,255,255);

        } elseif (strtoupper($db02_descr) == "DATA") {
//	  $posicao_assinatura=$pdf->gety();
	  $sqltexto = "select munic from db_config where codigo = " . db_getsession("DB_instit");
	  $resulttexto = pg_exec($sqltexto);
	  db_fieldsmemory($resulttexto,0,true);
	  $texto = $munic .', '.date('d',strtotime($k60_datadeb)).' de '.db_mes(date('m',strtotime($k60_datadeb))).' de ' . date('Y',strtotime($k60_datadeb)) .'.';
//          $pdf->sety($posicao_assinatura+10);
//          $pdf->cell($db02_inicia+0,4+$db02_espaca,"",0,0,"J",0);
	  $pdf->MultiCell(0,4+$db02_espaca,$texto,"0","R",0,$db02_inicia+0);
	  $pdf->Ln(1);

        } elseif ($db02_descr == "ASSINATURA") {
//	  echo $posicao_assinatura; exit;
          $pdf->Image('imagens/files/assinatura_notificacao.jpg',140,$posicao_assinatura,45);
	  $pdf->sety($posicao_assinatura+43);
	  $pdf->MultiCell(170,5,$texto,0,"R",0);
//          $pdf->text(30,200,$texto);

      } elseif (strtoupper($db02_descr) == "SEED") {

          //$pdf->sety(210);
          $pdf->sety(190+35);
          $pdf->SetFont('Arial','',12);
	  $pdf->cell(40,5,"NOTIFICAÇÃO : ",0,0,"L",0);
          $pdf->SetFont('Arial','B',12);
//	  die(db_formatar($notifica,'s','0',5,'e'));
	  $pdf->cell(50,5,db_formatar($notifica,'s','0',5,'e'),0,0,"L",0);
          
//		$this->objpdf->setfillcolor(245);
//		$this->objpdf->roundedrect($xcol-2,$xlin-18,206,144.5,2,'DF','1234');
	  
    	  $pdf->setfillcolor(245);
	  $pdf->RoundedRect(5,190+35,145,29,0,'DF','1234');

          $pdf->SetFont('Arial','',12);
	  $pdf->ln(0);
	  $pdf->cell(40,5,"DESTINATÁRIO: ",0,0,"L",0);
          $pdf->SetFont('Arial','B',12);
	  $pdf->cell(100,5,$z01_nome,0,1,"L",0);
          $pdf->SetFont('Arial','',12);
	  $pdf->cell(40,5,"ENDEREÇO: ",0,0,"L",0);
          $pdf->SetFont('Arial','B',12);
	  $pdf->cell(50,5,trim($z01_ender).", ".trim($z01_numero)."  ".trim($z01_compl),0,1,"L",0);

          $pdf->SetFont('Arial','',12);
	  $pdf->cell(40,5,($z01_bairro == ""?"":"BAIRRO: "),0,0,"L",0);
          $pdf->SetFont('Arial','B',12);
	  $pdf->cell(20,5,$z01_bairro,0,1,"L",0);

          $pdf->SetFont('Arial','',12);
	  $pdf->cell(40,5,"MUNICIPIO:",0,0,"L",0);
          $pdf->SetFont('Arial','B',12);
	  $pdf->cell(50,5,$z01_munic ."/".$z01_uf . " - " . substr($z01_cep,0,5)."-".substr($z01_cep,5,3),0,1,"L",0);

          $pdf->SetFont('Arial','',12);
	  $pdf->cell(40,5,"NOTIFICAÇÃO: ",0,0,"L",0);
          $pdf->SetFont('Arial','B',12);
	  $pdf->cell(30,5,db_formatar($notifica,'s','0',5,'e'),0,0,"L",0);

          $pdf->SetFont('Arial','',12);
	  if ($xcodigo == "numcgm") {
	    $pdf->cell(30,5,"CGM:",0,0,"L",0);
            $pdf->SetFont('Arial','B',12);
	    $pdf->cell(20,5,$$xcodigo1,0,1,"L",0);
	  } elseif ($xcodigo == "matric") {
	    $pdf->cell(30,5,"MATRÍCULA:",0,0,"L",0);
            $pdf->SetFont('Arial','B',12);
	    $pdf->cell(20,5,$$xcodigo1,0,1,"L",0);
	  } elseif ($xcodigo == "inscr") {
	    $pdf->cell(30,5,"INSCRIÇÃO:",0,0,"L",0);
            $pdf->SetFont('Arial','B',12);
	    $pdf->cell(20,5,$$xcodigo1,0,1,"L",0);
	  }
	  
	  
	  $pdf->RoundedRect(150,190+35,55,67,0,'','1234');
	  $pdf->SetXY(150,190+35); 
	  $pdf->SetFont('Arial','',8);
	  $pdf->cell(55,5,"CARIMBO",0,0,"C",0);

          $pdf->SetXY(5,220+35); 
          $pdf->SetFont('Arial','B',8);
	  $pdf->cell(50,5,"Motivos da não entrega",1,0,"C",0);
          $pdf->SetFont('Arial','B',12);
	  $pdf->cell(95,5,"Comprovante de Entrega",1,1,"C",0);

          $pdf->SetFont('Arial','',7);
	  
	  $pdf->cell(2,3,"",0,1,"L",0);

	  $pdf->cell(20,5,"Mudou-se",0,0,"L",0);
	  $pdf->RoundedRect(7,229+35,2,2,0,'DF','1234');
	  $pdf->cell(2,5,"",0,0,"L",0);
          $pdf->cell(20,5,"Ausente",0,1,"L",0);
	  $pdf->RoundedRect(29,229+35,2,2,0,'DF','1234');
//	  $pdf->cell(2,5,"",0,0,"L",0);
//	  $pdf->cell(20,5,"Não Existe N".chr(176),0,1,"L",0);
//	  $pdf->RoundedRect(54,226+35,2,2,0,'DF','1234');
	  	    
//	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Recusado",0,0,"L",0);
	  $pdf->RoundedRect(7,234+35,2,2,0,'DF','1234');
	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Não procurado",0,1,"L",0);
	  $pdf->RoundedRect(29,234+35,2,2,0,'DF','1234');
//	  $pdf->cell(2,5,"",0,0,"L",0);
//	  $pdf->cell(20,5,"Endereço Insuficiente",0,1,"L",0);
//	  $pdf->RoundedRect(54,231+35,2,2,0,'DF','1234');
	  
//	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Desconhecido",0,0,"L",0);
	  $pdf->RoundedRect(7,239+35,2,2,0,'DF','1234');
	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Falecido",0,1,"L",0);
	  $pdf->RoundedRect(29,239+35,2,2,0,'DF','1234');
//	  $pdf->cell(2,5,"",0,0,"L",0);
//	  $pdf->cell(20,5,"Outros",0,1,"L",0);
//	  $pdf->RoundedRect(54,236+35,2,2,0,'DF','1234');

//	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Não existe n" . chr(176),0,0,"L",0);
	  $pdf->RoundedRect(7,244+35,2,2,0,'DF','1234');
	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Outros",0,1,"L",0);
	  $pdf->RoundedRect(29,244+35,2,2,0,'DF','1234');

//	  $pdf->cell(2,5,"",0,0,"L",0);
	  $pdf->cell(20,5,"Endereço insuficiente",0,0,"L",0);
	  $pdf->RoundedRect(7,249+35,2,2,0,'DF','1234');


/*
          $pdf->SetFont('Arial','B',6);
	  $pdf->cell(15,4,"Para uso",0,0,"L",0);
          $pdf->SetFont('Arial','',6);
	  $pdf->cell(15,3,"Data","LTR",0,"L",0);
	  $pdf->cell(20,3,"Entregador","LTR",0,"L",0);
	  $pdf->cell(19,3,"N".chr(176)." de se.","LTR",1,"L",0);
          $pdf->SetFont('Arial','B',6);
	  $pdf->cell(15,4,"dos Correios",0,0,"L",0);
          $pdf->SetFont('Arial','',6);
	  $pdf->cell(15,5,"","LBR",0,"L",0);
	  $pdf->cell(20,5,"","LBR",0,"L",0);
	  $pdf->cell(19,5,"","LBR",1,"L",0);
*/
	  $pdf->RoundedRect(5,220+35,50,37,0,'D','1234');
          
          $pdf->SetFont('Arial','B',8);
          $pdf->SetXY(57,225+38); 
          $pdf->SetX(57); 
	  $pdf->cell(35,7,"Assinatura Recebedor: _____________________________________ ",0,1,"L",0);

          $pdf->SetX(57); 
	  $pdf->cell(35,7,"Nome legível: _____________________________________________",0,1,"L",0);

          $pdf->SetX(57); 
	  $pdf->cell(50,7,"CI : ____________________ ",0,0,"L",0);

	  $pdf->cell(35,7,"Data : ______/______/_______ ",0,1,"L",0);

          $pdf->SetX(57); 
	  $pdf->cell(55,7,"Assinatura/ECT: ____________________",0,0,"L",0);
	  
	  $pdf->cell(15,7,"Matrícula : _____________",0,0,"L",0);

	  /*$pdf->Text(85,249,"Contribuinte: ");
	  $pdf->Text(160,249,"Notificação No.: ".db_formatar($notifica,'s','0',5,'e'));*/
	  $pdf->RoundedRect(55,220+35,95,37,0,'D','1234');

	} else {
//// 	  if (strlen($texto) <= 100) {

    
//   	echo("x: $texto - " . $pdf->GetStringWidth($texto) . "<br>");
	
 	  if ($pdf->GetStringWidth($texto) <= 100 and 1 == 2) {
	    //$pdf->cell($db02_inicia+0,4+$db02_espaca,str_repeat(" ",$db02_inicia+0),0,0,"L",0);
////			if ($db02_descr == 'ATENCIOSAMENTE,') {
////      	die("x: $texto - " . $pdf->GetStringWidth($texto) . " - db02_inicia: $db02_inicia - db02_espaca: $db02_espaca" . "<br>");
////			}

	    $pdf->cell($db02_inicia+0,4+$db02_espaca," ",0,0,"L",0);
////			$pdf->write(4+$db02_espaca, $texto);
	    //$pdf->cell($db02_inicia+0,4+$db02_espaca,$texto,0,1,"L",0);
  	  $pdf->MultiCell(0,4+$db02_espaca,$texto,"0","L",0,$db02_inicia+0);
	  } else {
      $imprimir= explode("#\n",$texto);
//			for ($linhaimp=0; $linhaimp<sizeof($imprimir); $linhaimp++) {
//				echo "x: $linhaimp - "  . $imprimir[$linhaimp] . "<br>";
//			}
  	  $pdf->MultiCell(0,4+$db02_espaca,$texto,"0","J",0,$db02_inicia+0);
	  }
	  $posicao_assinatura=$pdf->gety();
	}
      }


    if ($tiporel == 11) {

			$pdf->AddPage();
			CabecNotif(&$pdf, 1, "CENTRAL DE ATENDIMENTO");
			$pdf->cell(45,05,"PARA:",0,1,"L",0);

			$z01_ender = "";
			$z01_munic = "";
			
      if ($k60_tipo == 'M'){

        $sqlpropri = "select z01_nome, codpri, nomepri, j39_numero, j39_compl, j13_descr as z01_bairro, j34_setor, j34_quadra, j34_lote, j34_zona, j34_area, j01_tipoimp from proprietario where j01_matric = $matric";
        $resultpropri = pg_exec($sqlpropri);
				if (pg_numrows($resultpropri) > 0) {
					db_fieldsmemory($resultpropri,0);
				}

				if ($tratamento == 1) {

					$sql3 = "select j43_dest, j43_bairro, j43_ender, j43_numimo, j43_comple, j43_munic, j43_uf, j43_cep, j43_cxpost from iptuender where j43_matric = $matric";
					$resultender = pg_exec($sql3) or die($sql3);
					$destinatario = $z01_nome;
					if (pg_numrows($resultender) > 0) {
						db_fieldsmemory($resultender, 0);
						$z01_ender = $j43_ender . ", " . $j43_numimo . " - " . $j43_comple;
						$z01_bairro = $j43_bairro;
						$z01_munic = $j43_munic . "/" . $j43_uf . " - " . $j43_cep;
						if ($j43_dest <> "") {
							$destinatario = $j43_dest;
						}
					} else {
						if (substr($j01_tipoimp,0,1) == "P") {
							$z01_ender = $nomepri . ", " . $j39_numero . " - " . $j39_compl;
							$sqlmunic = "select munic, uf, cep from db_config where codigo = " . db_getsession("DB_instit");
							$resultmunic = pg_exec($sqlmunic);
							db_fieldsmemory($resultmunic,0);
							$z01_munic = $munic . "/" . $uf . " - " . $cep;
						} else {
							$sqlender = "select z01_ender, z01_numero, z01_compl, z01_bairro, z01_munic, z01_uf, z01_cep, z01_cxpostal from cgm where z01_numcgm = $cgm";
							$resultender = pg_exec($sqlender);
							db_fieldsmemory($resultender,0,true);
							$z01_ender = $z01_ender . ", " . $z01_numero . " - " . $z01_compl;
							$z01_munic = $z01_munic . "/" . $z01_uf . " - " . $z01_cep;
						}
					}
          $pdf->cell(100,5,"DESTINATÁRIO: " . $destinatario,0,1,"L",0);
					
			  } else {

          $pdf->cell(100,5,"DESTINATÁRIO: " . $z01_nome,0,1,"L",0);
					$sqlender = "select z01_ender, z01_numero, z01_compl, z01_bairro, z01_munic, z01_uf, z01_cep, z01_cxpostal from cgm where z01_numcgm = $cgm";
					$resultender = pg_exec($sqlender);
					db_fieldsmemory($resultender,0,true);
					$z01_ender = $z01_ender . ", " . $z01_numero . " - " . $z01_compl;
					$z01_munic = $z01_munic . "/" . $z01_uf . " - " . $z01_cep;

				}

      } elseif ($k60_tipo == 'I') {

			  $pdf->cell(100,5,"DESTINATÁRIO: " . $z01_nome,0,1,"L",0);
				$sqlempresa = "select z01_ender, z01_numero, z01_compl, z01_bairro, z01_munic, z01_uf, z01_cep, z01_cxpostal from issbase inner join cgm on z01_numcgm = q02_numcgm where q02_inscr = $q02_inscr";
				$resultempresa = pg_exec($sqlempresa);
				if (pg_numrows($resultempresa) > 0) {
					db_fieldsmemory($resultempresa,0);
				}
				$z01_ender = $z01_ender . ", " . $z01_numero . " - " . $z01_compl;
				$z01_munic = $z01_munic . "/" . $z01_uf . " - " . $z01_cep;

      } elseif ($k60_tipo == 'N') {

			  $pdf->cell(100,5,"DESTINATÁRIO: " . $z01_nome,0,1,"L",0);
				$sqlender = "select z01_ender, z01_numero, z01_compl, z01_bairro, z01_munic, z01_uf, z01_cep, z01_cxpostal from cgm where z01_numcgm = $cgm";
				$resultender = pg_exec($sqlender);
        db_fieldsmemory($resultender,0,true);
				$z01_ender = $z01_ender . ", " . $z01_numero . " - " . $z01_compl;
				$z01_munic = $z01_munic . "/" . $z01_uf . " - " . $z01_cep;

      }

			$pdf->cell(100,5,"ENDERECO: " . $z01_ender,0,1,"L",0);
			$pdf->cell(100,5,"BAIRRO: " . $z01_bairro,0,1,"L",0);
			$pdf->cell(100,5,"MUNICIPIO: " . $z01_munic,0,1,"L",0);
			
    }

   } // fim do for

} elseif( $tiporel == 2 ) {
   $pdf->addpage();
   $pdf->setfillcolor(235);
   $pdf->setfont('arial','b',8);
   $pdf->cell(15,05,'Notificação',1,0,"c",1);
   $pdf->cell(15,05,$xtipo,1,0,"c",1);
   $pdf->cell(15,05,'Numcgm',1,0,"c",1);
   $pdf->cell(80,05,'Nome',1,1,"c",1);
   $pdf->setfont('arial','',8);
   $total = 0;
   for($x=$lim1;$x < $lim2;$x++){
//   for($x=0;$x < pg_numrows($result);$x++){
     db_fieldsmemory($result,$x);
     if ($pdf->gety() > $pdf->h - 35){
        $pdf->addpage();
        $pdf->setfont('arial','b',8);
        $pdf->cell(15,05,'Notificação',1,0,"c",1);
        $pdf->cell(15,05,$xtipo,1,0,"c",1);
        $pdf->cell(15,05,'Numcgm',1,0,"c",1);
        $pdf->cell(80,05,'Nome',1,1,"c",1);
        $pdf->setfont('arial','',8);
     }
     $pdf->cell(15,05,$notifica,0,0,"R",0);
     $pdf->cell(15,5,$$xcodigo1,0,0,"R",0);
     $pdf->cell(15,5,$z01_numcgm,0,0,"R",0);
     $pdf->cell(80,5,$z01_nome,0,1,"L",0);
     $total += 1;
   }
   $pdf->cell(125,05,'Total de Registros:   '.$total,1,1,"c",1);

}elseif ( $tiporel == 3 ){
//   for($x=0;$x < 2;$x++){
      $sqlparag = "select * 
                  from db_documento 
                  inner join db_docparag on db03_docum = db04_docum 
                  inner join db_paragrafo on db04_idparag = db02_idparag 
                  where db03_docum = 25 and db03_instit = " . db_getsession("DB_instit");
   $resparag = pg_query($sqlparag);
//   db_criatabela($resparag);
//   for($x=0;$x < 20;$x++){
//   for($x=0;$x < pg_numrows($result);$x++){


   for($x=$lim1;$x < $lim2;$x++){
      db_fieldsmemory($result,$x);
      $pdf->AddPage();
      $pdf->SetFont('Arial','',13);
      $numcgm = @$j01_numcgm;
      $matric = @$j01_matric;
      $inscr  = @$q02_inscr;
      if($matric != ''){
         $xmatinsc = " matric = ".$matric." and ";
         $matinsc = "sua matrícula n".chr(176)." ".$matric;
      }else if($inscr != ''){
         $xmatinsc = " inscr = ".$inscr." and ";
         $matinsc = "sua inscrição n".chr(176)." ".$inscr;
      }else{
         $xmatinsc = " numcgm = ".$numcgm." and ";
         $matinsc = "V.Sa.";
      }
      $matricula = $matric;
      $inscricao = $inscr;
      $cgm = $z01_numcgm;
      $sql10 = "select distinct tipo,k00_descr from devedores inner join arretipo on k00_tipo = tipo where $xmatinsc $jtipos data = '$k60_datadeb' ";
      $result10 = pg_exec($sql10);
      $xxtipos = '';
      $virgula = '';
      for($i = 0;$i < pg_numrows($result10);$i++){
         db_fieldsmemory($result10,$i);
         $xxtipos .= $virgula.$k00_descr;
         $virgula = ', ';
      }
//      $xxtipos = db_geratexto($xxtipos);

      $pdf->multicell(0,4,$munic.", ".date('d',$k60_datadeb)." de ".db_mes(date('m',$k60_datadeb))." de ".date('Y',$k60_datadeb).".",0,"R",0);
      $pdf->ln(10);
      
      for($ip = 0;$ip < pg_numrows($resparag);$ip++){
        db_fieldsmemory($resparag,$ip);
	if($db02_alinha != 0)
	  $pdf->setx($pdf->lMargin + $db02_alinha);
        $pdf->multicell(0,6,db_geratexto($db02_texto),0,"J",0,$db02_inicia);
	if($db02_espaca > 1)
	  $pdf->ln($db02_espaca);
      }
      $pdf->setx(100);
      $posicaoy = $pdf->gety();
      $pdf->Image('imagens/assinatura/shimi.jpg',115,$posicaoy+10,45);
      $pdf->MultiCell(90,6,"\n\n\n"."Jorge Alfredo Schmitt"."\n"."Coordenador de Unidade",0,"C",0,15);
 
      if ($k60_tipo == 'M') {
	 $sql3 = "select j43_ender as z01_ender, j43_numimo as z01_numero, j43_comple as z01_compl, j43_munic as z01_munic, j43_uf as z01_uf, j43_cep as z01_cep , j43_cxpost as z01_cxpostal from iptuender where j43_matric = $matric";
	 $result3 = pg_exec($sql3);
         if (pg_numrows($result3) > 0) {
            db_fieldsmemory($result3,0);
	    $sql3 = "select z01_nome from cgm where z01_numcgm = $cgm";
	    $result3 = pg_exec($sql3);
            db_fieldsmemory($result3,0);
         } else {
	    $sql3 = "select * from cgm where z01_numcgm = $cgm";
   	    $result3 = pg_exec($sql3);
         }
      } else { 
	 $sql3 = "select * from cgm where z01_numcgm = $cgm";
	 $result3 = pg_exec($sql3);
      }

      if (pg_numrows($result3) > 0){
         db_fieldsmemory($result3,0);
         $pdf->text(10,248,"Contribuinte: ");
         $pdf->SetFont('Arial','',10);
         $pdf->text(10,254,strtoupper($xtipo).' - '.$$xcodigo1);
         $pdf->text(10,259,$z01_nome);
         if ($z01_cxpostal==""){
            $pdf->text(10,264,$z01_ender.", ".$z01_numero." ".$z01_compl);
         } else { 
            $pdf->text(10,264,$z01_cxpostal);
         }
         $pdf->text(10,269,$z01_munic." - ".$z01_uf);
         $pdf->text(10,274,substr($z01_cep,0,5) . "-" . substr($z01_cep,5,3));
     }

   }

}

$pdf->Output();

function CabecNotif($pdf, $endereco, $central) {
	$sql = "select nomeinst,bairro,cgc,ender,upper(munic) as munic,uf,telef,email,url,logo from db_config where codigo = ".db_getsession("DB_instit");
	$result = pg_query($sql);
	global $nomeinst;
	global $ender;
	global $munic;
	global $cgc;
	global $bairro;
	global $uf;
	//echo $sql;
	db_fieldsmemory($result,0);
	/// seta a margem esquerda que veio do relatorio
	$S=$pdf->lMargin;
	$pdf->SetLeftMargin(10);
	$Letra = 'Times';
	$posini = 20;
	if ($endereco == 1) {
	  $pdf->Image("imagens/files/logo_boleto.png",$posini,100,24);
	  $pdf->Ln(90);
	} else {
	  $pdf->Image("imagens/files/logo_boleto.png",$posini,8,24);
	}
	$pdf->Ln(5);
	$pdf->SetFont($Letra,'',10);
	$pdf->MultiCell(0,4,"ESTADO DO RIO GRANDE DO SUL",0,"C",0);
	$pdf->SetFont($Letra,'B',13);
	$pdf->MultiCell(0,6,$nomeinst,0,"C",0);
	$pdf->SetFont($Letra,'B',12);
	$pdf->MultiCell(0,4,@$GLOBALS["head1"],0,"C",0);
	if ($endereco == 1) {
	  $pdf->MultiCell(0,5,"Central de Atendimento",0,"C",0);
	}
	$pdf->SetLeftMargin($S);
	$pdf->Ln(10);
	}

?>

