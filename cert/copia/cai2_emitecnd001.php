<?
include("libs/db_sql.php");
include("dbforms/db_funcoes.php");
include("classes/db_protparam_classe.php");
include("classes/db_certidao_classe.php");
include("classes/db_certidaocgm_classe.php");
include("classes/db_certidaoinscr_classe.php");
include("classes/db_certidaomatric_classe.php");
//die("adfasdfasd");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

if(isset($cadrecibo) && $cadrecibo == 't'){
	require('fpdf151/scpdf.php');
}else{
    require('fpdf151/pdf1.php');	
}

$clcertidao       = new cl_certidao;
$clcertidaocgm    = new cl_certidaocgm;
$clcertidaoinscr  = new cl_certidaoinscr;
$clcertidaomatric = new cl_certidaomatric;

//db_postmemory($HTTP_SERVER_VARS,2);exit;

//die("afsdfas dgfhkasg dfasgkf kasdf".$historico);
//$textarea = $historico;

//echo "$historico";
//exit;
//******************************************** G R A V A   A   C E R T I D A O **********************************************//	

    if($codproc && $codproc != ""){
	    $proc = ",conforme processo N".chr(176)." $codproc, ";   
	}
	$sqlerro=false;
	db_inicio_transacao();
	if($tipo==1){
		$clcertidao->p50_tipo = "p";
	}else if($tipo==2){
		$clcertidao->p50_tipo = "n";
	}else{
		$clcertidao->p50_tipo = "r";
	}
	$hj = date("Y-m-d",db_getsession('DB_datausu'));

	$clcertidao->p50_idusuario  = db_getsession('DB_id_usuario');
//	die($hj);
	$clcertidao->p50_data       = $hj;
	$clcertidao->p50_hora       = db_hora();
	$clcertidao->p50_ip         = db_getsession('DB_ip');
	if(isset($historico) && $historico!=""){
		$clcertidao->p50_hist = $historico; 
	}else{
		$clcertidao->p50_hist = " "; 
	  
	}
	$clcertidao->p50_web        = 'false';
	$clcertidao->incluir(null);
	if($clcertidao->erro_status=='0'){
		$erro_msg = $clcertidao->erro_msg."--- Inclusão Certidão";
		db_msgbox($erro_msg);
		$sqlerro=true;
	}

	if(isset($titulo) && $titulo == 'CGM'){
		$numcgm = $origem;
		$clcertidaocgm->p49_sequencial = $clcertidao->p50_sequencial; 
		$clcertidaocgm->p49_numcgm     = $numcgm;
		$clcertidaocgm->incluir();
		if($clcertidaocgm->erro_status=='0'){
			$erro_msg = $clcertidaocgm->erro_msg."--- Inclusão Certidão CGM";
			db_msgbox($erro_msg);
			$sqlerro=true;
		}
	}else if(isset($titulo) && $titulo == 'MATRICULA'){
		$matric = $origem;
		$clcertidaomatric->p47_sequencial = $clcertidao->p50_sequencial; 
		$clcertidaomatric->p47_matric     = $matric;
		$clcertidaomatric->incluir();
		if($clcertidaomatric->erro_status=='0'){
			$erro_msg = $clcertidaomatric->erro_msg."--- Inclusão Certidão Matricula";
			db_msgbox($erro_msg);
			$sqlerro=true;
		}
	}else if(isset($titulo) && $titulo == 'INSCRICAO'){
		$inscr = $origem;
		$clcertidaoinscr->p48_sequencial = $clcertidao->p50_sequencial; 
		$clcertidaoinscr->p48_inscr      = $inscr;
		$clcertidaoinscr->incluir();
		if($clcertidaoinscr->erro_status=='0'){
			$erro_msg = $clcertidaoinscr->erro_msg."--- Inclusão Certidão Inscrição";
			db_msgbox($erro_msg);
			$sqlerro=true;
		}
	}
		
	db_fim_transacao($sqlerro);

//**************************************************************************************************************************//
  if(isset($textarea) && $textarea != ""){
       $historico = $textarea;
  }else{
       $textarea = $historico;	
  }
  
  
	$sql = "select nomeinst,ender,munic,uf,telef,email,url,logo from db_config where codigo = ".@$GLOBALS["DB_instit"];
	$result = pg_query($sql);
	db_fieldsmemory($result,0);
	if($tipo==1){
		// certidao positiva 
		$tipocer = "CERTIDÃO POSITIVA DE DÉBITO"; 
		if(isset($matric)){
			$codtipo = 26;
			$sql = "select * from proprietario where j01_matric = $matric";
			$result = pg_query($sql);
         	db_fieldsmemory($result,0);
			if (isset($j01_baixax) && $j01_baixax != ""){
                $situinscr = "Situação da matrícula : MATRÍCULA BAIXADO ";
			}else{
                $situinscr = "Situação da matrícula : MATRÍCULA ATIVA ";
			}
         	/////// TEXTOS E ASSINATURAS
         	$instit = db_getsession("DB_instit");
         	$sqltexto = "select * from db_textos 
							where id_instit = $instit and (descrtexto like 'positiva%' or descrtexto like 'ass%')";
         	$resulttexto = pg_exec($sqltexto);
         	for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
            	db_fieldsmemory($resulttexto,$xx);
            	$text  = $descrtexto;
            	$$text = db_geratexto($conteudotexto); 
         	}  
         	////////
         	$texto1  = $positiva_mat1;
         	$texto2  = $positiva_mat2;
         	$texto3  = $positiva_mat3;
         	$texto4  = ''; 
         	//$texto1  = '                    CERTIFICAMOS a requerimento, que não existe cadastro em nome de '.$z01_nome.', e que nada deve à Fazenda Municipal até a presente data.'."\n".'                    Fica ressalvado o direito do Município de Sapiranga de apurar e cobrar eventuais débitos de responsabilidade do contribuinte supra identificado.'."\n".'                    E para que produza os efeitos a que se destina, emite a presente certidão que é válida por 60 (sessenta) dias a contar da data de sua expedição.';
    	}else if(isset($numcgm)){
       		$codtipo = 27;
       		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'positiva%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto); 
       		}  
       		////////
       		$texto1  = $positiva_cgm1;
       		$texto2  = $positiva_cgm2;
       		$texto3  = $positiva_cgm3;
       		$texto4  = '';
    	}else if(isset($inscr)){
       		$codtipo = 28;
       		$sql = "select * from empresa where q02_inscr = $inscr";
			
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
			if(isset($q02_dtbaix) && $q02_dtbaix != ""){
                $situinscr = "Situação do alvará : ALVARÁ BAIXADO ";
			}else{
                $situinscr = "Situação do alvará : ALVARÁ ATIVO ";
			}
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit 
							  and (descrtexto like 'positiva%' 
							     or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto); 
       		}  
       		////////
       		$texto1 = $positiva_ins1;
       		$texto2 = $positiva_ins2;
       		$texto3 = $positiva_ins3;
       		$texto4  = '';
		}
	}else if($tipo==2){
    	// certidao negativa
    	$tipocer = "CERTIDÃO NEGATIVA" ;
    	if(isset($matric)){
    		$codtipo = 29;
    		$sql = "select * from proprietario where j01_matric = $matric";
    		$result = pg_query($sql);
    		db_fieldsmemory($result,0);
			if (isset($j01_baixax) && $j01_baixax != ""){
                $situinscr = "Situação da matrícula : MATRÍCULA BAIXADO ";
			}else{
                $situinscr = "Situação da matrícula : MATRÍCULA ATIVA ";
			}

    		/////// TEXTOS E ASSINATURAS
    		$instit = db_getsession("DB_instit");
    		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'negativa%' or descrtexto like 'ass%')";
			$resulttexto = pg_exec($sqltexto);
    		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
       			db_fieldsmemory($resulttexto,$xx);
       			$text  = $descrtexto;
       			$$text = db_geratexto($conteudotexto); 
    		}  
    		////////
    		$texto1 = $negativa_mat1;
    		$texto2 = $negativa_mat2;
    		$texto3 = $negativa_mat3;
    		$texto4  = '';
    	}else if(isset($numcgm)){
       		$codtipo = 30;
       		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
       		$result = pg_query($sql);
       		//die($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'negativa%' or descrtexto like 'ass%')";
       		//die($sqltexto);
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
       			db_fieldsmemory($resulttexto,$xx);
        		$text  = $descrtexto;
        		$$text = db_geratexto($conteudotexto); 
       		}  	
       		////////
       		$texto1  = $negativa_cgm1;
       		$texto2  = $negativa_cgm2;
       		$texto3  = $negativa_cgm3;
       		$texto4  = '';
     	}else if(isset($inscr)){
       		$codtipo = 31;
       		$sql = "select * from empresa where q02_inscr = $inscr";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
			if(isset($q02_dtbaix) && $q02_dtbaix != ""){
                $situinscr = "Situação do alvará : ALVARÁ BAIXADO ";
			}else{
                $situinscr = "Situação do alvará : ALVARÁ ATIVO ";
			}
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'negativa%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
				db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto); 
       		}  	
       		////////
       		$texto1 = $negativa_ins1;
       		$texto2 = $negativa_ins2;
       		$texto3 = $negativa_ins3;
       		$texto4  = '';
     	} 
  	}else{
    	// certidao regular
     	$tipocer = "CERTIDÃO POSITIVA COM EFEITOS NEGATIVOS" ;
     	if(isset($matric)){
       		$codtipo = 32;
       		$sql = "select * from proprietario where j01_matric = $matric";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
			if (isset($j01_baixax) && $j01_baixax != ""){
                $situinscr = "Situação da matrícula : MATRÍCULA BAIXADO ";
			}else{
                $situinscr = "Situação da matrícula : MATRÍCULA ATIVA ";
			}

       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'regular%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto); 
       		}  
       		////////
       		$texto1 = $regular_mat1;
       		$texto2 = $regular_mat2;
       		$texto3 = $regular_mat3;
       		$texto4  = '';
     	}else if(isset($numcgm)){
       		$codtipo = 33;
       		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'regular%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto); 
       		}  
       		////////
       		$texto1  = $regular_cgm1;
       		$texto2  = $regular_cgm2;
       		$texto3  = $regular_cgm3;
       		$texto4  = '';
     	}else if(isset($inscr)){
       		$codtipo = 34;
       		$sql = "select * from empresa where q02_inscr = $inscr";
       		$result = pg_query($sql);
       		db_fieldsmemory($result,0);
			if(isset($q02_dtbaix) && $q02_dtbaix != ""){
                $situinscr = "Situação do alvará : ALVARÁ BAIXADO ";
			}else{
                $situinscr = "Situação do alvará : ALVARÁ ATIVO ";
			}
       		/////// TEXTOS E ASSINATURAS
       		$instit = db_getsession("DB_instit");
       		$sqltexto = "select * from db_textos 
							where id_instit = $instit and ( descrtexto like 'regular%' or descrtexto like 'ass%')";
       		$resulttexto = pg_exec($sqltexto);
       		for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
          		db_fieldsmemory($resulttexto,$xx);
          		$text  = $descrtexto;
          		$$text = db_geratexto($conteudotexto); 
       		}  
       		////////
       		$texto1 = $regular_ins1;
       		$texto2 = $regular_ins2;
       		$texto3 = $regular_ins3;
       		$texto4  = '';
     	}	 
  	}
 
 	//echo $codproc;
	
	$sqlparag = "select db02_texto
				   from db_documento
						inner join db_docparag on db03_docum = db04_docum
						inner join db_tipodoc on db08_codigo  = db03_tipodoc
						inner join db_paragrafo on db04_idparag = db02_idparag
				 where db03_tipodoc = 1017 and db03_instit = " . db_getsession("DB_instit")." order by db04_ordem ";
//	die($sqlparag);
	$resparag = pg_query($sqlparag);
	if (pg_numrows($resparag) == 0){
		 $head1 = 'SECRETARIA DE FINANÇAS';
	}else{
		 db_fieldsmemory( $resparag, 0 );
		 $head1 = $db02_texto;
	}
 /// 	$head1 = "DEPARTAMENTO DE FAZENDA";
  
  	//$head4 = "CERTIDÃO No. ".$codproc;
  	//$head6 = $tipocer;
  	//$pdf = new PDF1(); 		// abre a classe

//****************************************    P D F   ******************************************************// 

    $sqlDbconfig = "select * from db_config where codigo = ".db_getsession('DB_instit');
    $rsDbconfig  = pg_query($sqlDbconfig);
    db_fieldsmemory($rsDbconfig,0);


   if(isset($cadrecibo) && $cadrecibo == 't'){
     	$pdf = new scpdf(); 		// abre a classe
   }else{
  	    $pdf = new PDF1(); 		// abre a classe
   }
  	$pdf->Open(); 		    	// abre o relatorio
  	$pdf->AliasNbPages();    	// gera alias para as paginas
  	$pdf->AddPage(); 	    	// adiciona uma pagina
	$pdf->SetAutoPageBreak('on',0);
  	$pdf->SetTextColor(0,0,0);
  	$pdf->SetFillColor(255);
    if(isset($cadrecibo) && $cadrecibo == 't'){
		$pdf->settopmargin(1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Image('imagens/files/Brasao.png',20,10,15);
        $pdf->sety(15);
        $pdf->setfont('Arial','B',18);
        $pdf->Multicell(0,8,$nomeinst,0,"C",0); // prefeitura
    } 
    $y = $pdf->gety(); 
    $pdf->sety($y+10); 
  	$Letra = 'Times';
	$TamLetra = 10;
  	$pdf->SetFont($Letra,'B',$TamLetra+1);
// 	$pdf->MultiCell(0,4,$tipocer.' N'.chr(176).' '.$codproc,0,"C",0);
 	$pdf->MultiCell(0,4,$tipocer.' N'.chr(176).' '.$clcertidao->p50_sequencial,0,"C",0);
  	$pdf->SetFont($Letra,'',$TamLetra);
  	$pdf->Ln(10);
	
        $pdf->MultiCell(0,6,$texto1,0,"J",0);
	$pdf->MultiCell(0,6,$texto2,0,"J",0);
	$pdf->MultiCell(0,6,$texto3,0,"J",0);
 	$pdf->MultiCell(0,6,$texto4,0,"J",0);

  	$pdf->Cell(10,4,"",0,1,"L",0);
//  $pdf->SetY(50);
//  $pdf->Ln(30);
  	$resultnomelogin = pg_exec("select nome from db_usuarios where id_usuario = " . db_getsession("DB_id_usuario"));
	$pdf->MultiCell(0,8,$munic.', '.date('d')." de ".db_mes(date('m'))." de ".date('Y').'.',0,0,"R",0);
  	$pdf->SetX($x+80);
	
  	$y = $pdf->GetY();
	$x = $pdf->GetX();
  	$pdf->SetXY($x+80,$y+10);

// 	$pdf->MultiCell(90,5,pg_result($resultnomelogin,0,0),0,"C",0);
//  $pdf->MultiCell(90,5,"",0,"C",0);
//  $y = $pdf->GetY();
	
    if(isset($cadrecibo) && $cadrecibo == 't'){
  		$y = $pdf->w-20;
	}else{
  		$y = $pdf->GetY()-20;
	}
	$x = $pdf->GetX();

   $pdf->SetY($y+15);
    $pdf->MultiCell(90,5,"_________________________________"."\n".pg_result($resultnomelogin,0,0),0,"C",0);

    $pdf->SetX(110);
//	$pdf->MultiCell(90,5,'_________________________________',0,"C",0);
//	$pdf->Text(110,$y+20,'_________________________________',0,0,"L",0);

/************************************   R O D A P E (recibo)   D A   C N D  *******************************************************/

//  $mostrarecibo => parametro q define se mostra ou naun mostra o recibo no rodape da cnd...
//	$cadrecibo = 't';

    if(isset($cadrecibo) && $cadrecibo == 't'){
            $dtimp = date("Y-m-d",db_getsession('DB_datausu'));

            //$y = $pdf->GetY();
		    /**/
			$y = $pdf->w-28;
			$x = $pdf->GetX();
			/**/
			$pdf->SetXY($x,$y+3);
			$pdf->RoundedRect(5,$y+36,80,28,'','1234');

			$pdf->Ln(17);
			$TamLetra = 7;
			$alt      = 4;
			$b        = 0;
			
//			die("select * from recibo where k00_numpre = $k03_numpre");
			$rsRecibo   = pg_query("select * from recibo inner join tabrec on k00_receit = k02_codigo where k00_numpre = $k03_numpre");
			$intNumrows = pg_numrows($rsRecibo); 
			if($intNumrows == 0){
			    db_redireciona('db_erros.php?fechar=true&db_erro=Recibo não cadastrado');			  
			}
			
            for($ii=0;$ii < $intNumrows;$ii++){
			  db_fieldsmemory($rsRecibo,$ii);
			  if($ii==0){
				 $taxa1      = $k02_drecei;
                 $valor1     = $k00_valor;
			  }  
			  if($ii==1){
				 $taxa2      = $k02_drecei;
                 $valor2     = $k00_valor;
			  }  
			  if($ii==2){
				 $taxa3      = $k02_drecei;
                 $valor3     = $k00_valor;
			  }  
              $valortotal += $k00_valor;			  
			}			
		

//*******************************************************************************************************************//		
			
            $y = $pdf->GetY();
			$x = $pdf->GetX();
			$pdf->SetXY($x,$y+18);

			$pdf->SetFont('Arial','B',$TamLetra-2);
			$pdf->cell(20,3,"$titulo",$b,0,"L",0);//cgm matricula ou inscricao
			$pdf->cell(20,3,"Dt impr.",$b,0,"L",0);
			$pdf->cell(20,3,"Dt Venc",$b,0,"L",0);
			$pdf->cell(20,3,"",$b,1,"L",0);
			
		
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->SetFont('Arial','',$TamLetra);

			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(20,$alt,"$origem",$b,0,"L",0);//cgm matricula ou inscricao
			$pdf->cell(20,$alt,db_formatar($dtimp,"d"),$b,0,"L",0);
			$pdf->cell(20,$alt,db_formatar($k00_dtvenc,"d"),$b,0,"L",0);
			
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(20,$alt,"Valor",$b,0,"C",0);
			$pdf->SetFont('Arial','B',$TamLetra+1);
			$pdf->cell(110,$alt,"DOCUMENTO VÁLIDO SOMENTE APOS AUTENTICAÇÃO MECANICA ",$b,1,"C",0);

			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->SetFont('Arial','',$TamLetra-1);
			
			if(isset($taxa1) && $taxa1 != ""){
				$pdf->cell(60,$alt,"$taxa1","B",0,"L",0);
				$pdf->cell(20,$alt,"$valor1",$b,0,"C",0);
			    $pdf->SetFont('Arial','B',$TamLetra+1);
				$pdf->cell(110,$alt,"OU COMPROVANTE DE QUITAÇÃO",$b,1,"C",0);
			}else{
				$pdf->cell(60,$alt,"",$b,0,"L",0);
				$pdf->cell(20,$alt,"",$b,0,"C",0);
				$pdf->cell(110,$alt,"",$b,1,"C",0);
			}

			$pdf->SetFont('Arial','',$TamLetra-1);
			
			if(isset($taxa2) && $taxa2 != ""){
				$pdf->cell(60,$alt,"$taxa2","B",0,"L",0);
				$pdf->cell(20,$alt,"$valor2",$b,0,"C",0);
			}else{
				$pdf->cell(60,$alt,"",$b,0,"L",0);
				$pdf->cell(20,$alt,"",$b,0,"C",0);
			}
			
			$pdf->SetFont('Arial','B',$TamLetra+1);
			$pdf->cell(110,$alt," A U T E N T I C A Ç Ã O   M E C Â N I C A ",$b,1,"C",0);
			
			$pdf->SetFont('Arial','',$TamLetra-1);
			if(isset($taxa3) && $taxa3 != ""){
				$pdf->cell(60,$alt,"$taxa3","B",0,"L",0);
				$pdf->cell(20,$alt,"$valor3",$b,1,"C",0);
			}else{
				$pdf->cell(60,$alt,"",$b,0,"L",0);
				$pdf->cell(20,$alt,"",$b,1,"C",0);
			}

			$pdf->SetFont('Arial','B',$TamLetra-1);
			$pdf->cell(60,$alt,"Valor Total : ",$b,0,"R",0);
			$pdf->cell(20,$alt,"$valortotal",$b,1,"C",0);
            
            $y = $pdf->GetY();
			$x = $pdf->GetX();
			$pdf->SetXY($x,$y+10);

/******************************************************************************************************************************************/


			$pdf->RoundedRect(5,$y+9,200,41,0,'','1234');

			$pdf->SetFont('Arial','B',$TamLetra-2);
			$pdf->cell(110,3,"",$b,0,"L",0);
			$pdf->cell(20,3,"$titulo",$b,0,"L",0);//cgm matricula ou inscricao
			$pdf->cell(20,3,"Dt impr.",$b,0,"L",0);
			$pdf->cell(20,3,"Dt Venc",$b,0,"L",0);
			$pdf->cell(20,3,"",$b,1,"L",0);
			
		
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(40,$alt,"CONTRIBUINTE: ",$b,0,"L",0);
			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(70,$alt,@$z01_nome,$b,0,"L",0);

			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(20,$alt,"$origem",$b,0,"L",0);//cgm matricula ou inscricao
			$pdf->cell(20,$alt,db_formatar($dtimp,"d"),$b,0,"L",0);
			$pdf->cell(20,$alt,db_formatar($k00_dtvenc,"d"),$b,0,"L",0);
			
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(20,$alt,"Valor",$b,1,"C",0);

			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(40,$alt,"ENDEREÇO: ",$b,0,"L",0);
			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(70,$alt,trim(@$z01_ender).", ".trim(@$z01_numero)."  ".trim(@$z01_compl),$b,0,"L",0);
			
			$pdf->SetFont('Arial','',$TamLetra-1);
			if(isset($taxa1) && $taxa1 != ""){
				$pdf->cell(60,$alt,"$taxa1","B",0,"L",0);
				$pdf->cell(20,$alt,"$valor1",$b,1,"C",0);
			}else{
				$pdf->cell(60,$alt,"",$b,0,"L",0);
				$pdf->cell(20,$alt,"",$b,1,"C",0);
			}

			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(40,$alt,"MUNICIPIO:",$b,0,"L",0);
			$pdf->SetFont('Arial','',$TamLetra);
			$pdf->cell(70,$alt,@$z01_munic ."/".@$z01_uf . " - " . substr(@$z01_cep,0,5)."-".substr(@$z01_cep,$alt,3),$b,0,"L",0);
			
			$pdf->SetFont('Arial','',$TamLetra-1);
			if(isset($taxa2) && $taxa2 != ""){
				$pdf->cell(60,$alt,"$taxa2","B",0,"L",0);
				$pdf->cell(20,$alt,"$valor2",$b,1,"C",0);
			}else{
				$pdf->cell(60,$alt,"",$b,0,"L",0);
				$pdf->cell(20,$alt,"",$b,1,"C",0);
			}
			
			$pdf->cell(40,$alt,"",$b,0,"L",0);
			$pdf->cell(70,$alt,"",$b,0,"L",0);

			$pdf->SetFont('Arial','',$TamLetra-1);
			if(isset($taxa3) && $taxa3 != ""){
				$pdf->cell(60,$alt,"$taxa3","B",0,"L",0);
				$pdf->cell(20,$alt,"$valor3",$b,1,"C",0);
			}else{
				$pdf->cell(60,$alt,"",$b,0,"L",0);
				$pdf->cell(20,$alt,"",$b,1,"C",0);
			}
			
			$pdf->cell(40,$alt,"",$b,0,"L",0);
			$pdf->cell(70,$alt,"",$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(60,$alt,"Valor Total : ",$b,0,"R",0);
			$pdf->cell(20,$alt,"$valortotal",$b,1,"C",0);
			
			$pdf->SetFont('Arial','',$TamLetra+1);
			$pdf->cell(110,$alt,"$linhadigitavel",$b,0,"C",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(80,$alt,"",0,1,"C",0);

			$pdf->cell(40,$alt,"",$b,0,"L",0);
			$pdf->cell(70,$alt,"",$b,0,"L",0);
			$pdf->SetFont('Arial','B',$TamLetra);
			$pdf->cell(80,$alt," A U T E N T I C A Ç Ã O   M E C Â N I C A  ",0,1,"C",0);

            $y = $pdf->GetY();
			$x = $pdf->GetX();
			$pdf->SetXY($x,$y);

  	        $pdf->SetFillColor(000);
            $pdf->int25($x,$y-4,$codigobarras,13,0.341);			

	}
	
/*************************************************************************************************************************/
//die("adfasdfh asdfhl asdhfas d");
  	$pdf->Output();
?>
